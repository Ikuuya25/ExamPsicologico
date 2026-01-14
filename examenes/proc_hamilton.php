<?php
session_start();
include "../config/config.php";

// Depuración (puedes eliminar esto después)
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

    // 5. Insertar datos en la tabla resultados
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
    $preguntasFaltantes = [];
    for ($i = 1; $i <= 14; $i++) {
        if (!isset($_POST["pregunta$i"])) {
            $preguntasFaltantes[] = $i;
        }
    }

    if (!empty($preguntasFaltantes)) {
        die("Error: Faltan las preguntas: " . implode(', ', $preguntasFaltantes));
    }

    // 6. Calcular puntaje total (Hamilton tiene 14 ítems)
    $puntaje_total = 0;
    for ($i = 1; $i <= 14; $i++) {
        if (!isset($_POST["pregunta$i"])) {
            throw new Exception("Falta respuesta para pregunta $i");
        }
        $respuesta = (int)$_POST["pregunta$i"];
        if ($respuesta < 0 || $respuesta > 4) { // Hamilton usa escala 0-4
            throw new Exception("Respuesta inválida para pregunta $i");
        }
        $puntaje_total += $respuesta;
    }

    // 7. Insertar en tabla respuestas
    $stmt_resp = $conn->prepare("INSERT INTO respuestas 
                               (usuario_id, examen_id, respuesta, fecha) 
                               VALUES (?, ?, ?, NOW())");
    $stmt_resp->bind_param("iii", $usuario_id, $examen_id, $puntaje_total);
    
    if (!$stmt_resp->execute()) {
        throw new Exception("Error al guardar respuestas: " . $stmt_resp->error);
    }
    $stmt_resp->close();

    // 8. Actualizar estado del examen
    $stmt = $conn->prepare("UPDATE usuario_examen SET completado = 1 
                           WHERE usuario_id = ? AND examen_id = ?");
    $stmt->bind_param("ii", $usuario_id, $examen_id);
    $stmt->execute();
    $stmt->close();
    
    $update = $conn->prepare("UPDATE usuario_examen SET completado = 1, activo = 0 WHERE usuario_id = ? AND examen_id = ?");
    if (!$update) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $update->bind_param("ii", $usuario_id, $examen_id);
    if (!$update->execute()) {
        die("Error al ejecutar la consulta: " . $update->error);
    }

    $conn->commit();
    header("Location: ../examenes.php?success=1");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    header("Location: ../examenes.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>