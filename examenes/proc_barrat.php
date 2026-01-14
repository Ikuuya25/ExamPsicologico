<?php
session_start();
include "../config/config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->autocommit(false);

try {
    // 1. Verificar sesión
    if (empty($_SESSION['id'])) {
        throw new Exception("Debe iniciar sesión primero");
    }

    // 2. Validar campos obligatorios
    $required = ['nombre', 'edad', 'genero', 'examen_id'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Falta el campo requerido: $field");
        }
    }

    // 3. Sanitizar y validar datos
    $examen_id = (int)$_POST['examen_id'];
    $usuario_id = (int)$_SESSION['id'];
    
    if ($examen_id <= 0) {
        throw new Exception("ID de examen no válido");
    }

    // 4. Verificar que el examen está asignado al usuario
    $stmt = $conn->prepare("SELECT 1 FROM usuario_examen 
                           WHERE usuario_id = ? 
                           AND examen_id = ? 
                           AND activo = 1");
    $stmt->bind_param("ii", $usuario_id, $examen_id);
    $stmt->execute();
    
    if (!$stmt->get_result()->num_rows) {
        throw new Exception("No tienes asignado este examen o no está activo");
    }
    $stmt->close();

    // 5. Definir las preguntas por dimensión
    $preguntasCognitivas = [4, 7, 10, 13, 16, 19, 24, 27];
    $preguntasMotoras = [2, 6, 9, 12, 15, 18, 21, 23, 26, 29];
    $preguntasNoPlaneadas = [1, 3, 5, 8, 11, 14, 17, 20, 22, 25, 28, 30];

    // 6. Verificar que todas las respuestas estén presentes
    $preguntasFaltantes = [];
    $totalPreguntas = array_merge($preguntasCognitivas, $preguntasMotoras, $preguntasNoPlaneadas);
    
    foreach ($totalPreguntas as $pregunta) {
        if (!isset($_POST["pregunta$pregunta"])) {
            $preguntasFaltantes[] = $pregunta;
        }
    }

    if (!empty($preguntasFaltantes)) {
        throw new Exception("Faltan respuestas para las preguntas: " . implode(', ', $preguntasFaltantes));
    }

    // 7. Funciones de evaluación
    function evaluarCognitiva($valor) {
        // Escala inversa para preguntas cognitivas
        switch((int)$valor) {
            case 0: return 4; // Raramente o nunca
            case 1: return 3; // Ocasionalmente
            case 3: return 1; // A menudo
            case 4: return 0; // Siempre o casi siempre
            default: throw new Exception("Valor de respuesta no válido: $valor");
        }
    }
    
    function evaluarNormal($valor) {
        // Escala normal para otras preguntas
        switch((int)$valor) {
            case 0: return 0; // Raramente o nunca
            case 1: return 1; // Ocasionalmente
            case 3: return 3; // A menudo
            case 4: return 4; // Siempre o casi siempre
            default: throw new Exception("Valor de respuesta no válido: $valor");
        }
    }

    // 8. Calcular puntajes por dimensión
    $puntaje_cognitivo = 0;
    $puntaje_motor = 0;
    $puntaje_no_planeado = 0;

    foreach ($preguntasCognitivas as $pregunta) {
        $key = "pregunta$pregunta";
        if (!isset($_POST[$key])) {
            throw new Exception("Falta respuesta para pregunta $pregunta");
        }
        $valor = $_POST[$key];
        $puntaje_cognitivo += evaluarCognitiva($valor);
        error_log("Pregunta $pregunta (Cognitiva): Valor=$valor, Puntaje=".evaluarCognitiva($valor));
    }
    
    // Repite el mismo patrón para motoras y no planeadas...
    foreach ($preguntasMotoras as $pregunta) {
        $valor = $_POST["pregunta$pregunta"];
        $puntaje_motor += evaluarNormal($valor);
    }
    
    foreach ($preguntasNoPlaneadas as $pregunta) {
        $valor = $_POST["pregunta$pregunta"];
        $puntaje_no_planeado += evaluarNormal($valor);
    }

    // 9. Calcular puntaje total
    $puntaje_total = $puntaje_cognitivo + $puntaje_motor + $puntaje_no_planeado;

    $nombre_paciente = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $edad = (int)$_POST['edad'];
    $genero = in_array($_POST['genero'], ['Masculino', 'Femenino']) ? $_POST['genero'] : 'Otro';
    
    $stmt = $conn->prepare("INSERT INTO resultados 
                          (examen_id, usuario_id, nombre_paciente, edad, genero, fecha) 
                          VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisis", $examen_id, $usuario_id, $nombre_paciente, $edad, $genero);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al guardar resultados: " . $stmt->error);
    }
    
    $resultado_id = $conn->insert_id;
    $stmt->close();
 
    $stmt_resp = $conn->prepare("INSERT INTO respuestas 
                               (usuario_id, examen_id, respuesta, fecha,
                               puntaje_cognitivo, puntaje_motor, puntaje_no_planeado) 
                               VALUES (?, ?, ?, NOW(), ?, ?, ?)");
    $stmt_resp->bind_param("iiiiii", $usuario_id, $examen_id, $puntaje_total,
                          $puntaje_cognitivo, $puntaje_motor, $puntaje_no_planeado);
    
    if (!$stmt_resp->execute()) {
        throw new Exception("Error al guardar respuestas: " . $stmt_resp->error);
    }
    $stmt_resp->close();

    $update = $conn->prepare("UPDATE usuario_examen SET completado = 1, activo = 0 WHERE usuario_id = ? AND examen_id = ?");
    if (!$update) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $update->bind_param("ii", $usuario_id, $examen_id);
    if (!$update->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $update->error);
    }

    $conn->commit();
    header("Location: ../examenes.php?success=1");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    header("Location: ../examenes.php?error=" . urlencode($e->getMessage()));
    exit();
}