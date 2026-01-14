<?php
session_start();
include "../config/config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Preguntas invertidas (rojas)
$respuestasRojas = ["P3", "P4", "P5", "P6", "P7", "P9", "P10", "P12", "P13", "P16", "P17", "P20", "P22", "P27", "P28", "P30"];

// Función segura para consultas
function safe_prepare($conn, $query) {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error al preparar consulta: " . $conn->error);
    }
    return $stmt;
}

// Evaluar el resultado del PRP
function evaluarPuntajePRP($puntaje) {
    if ($puntaje > 135) return "Seguro";
    if ($puntaje < 118) return "Propenso o inseguro";
    return "Neutro";
}

// Calcular el puntaje sumando según si es pregunta roja o amarilla
function calcularPuntajePRP($respuestas, $rojas) {
    $total = 0;
    foreach ($respuestas as $pregunta => $valor) {
        if (in_array($pregunta, $rojas)) {
            // Pregunta roja: se cuenta de 1 a 5 (1 es el más seguro)
            $total += $valor;
        } else {
            // Pregunta amarilla: se invierte (5 es el más seguro)
            $total += (6 - $valor);
        }
    }
    return $total;
}

try {
    if (empty($_SESSION['id'])) {
        throw new Exception("Debe iniciar sesión primero");
    }

    $nombre = trim($_POST['nombre'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);
    $genero = $_POST['genero'] ?? '';
    $examen_id = (int)($_POST['examen_id'] ?? 0);
    $usuario_id = (int)$_SESSION['id'];

    if ($examen_id <= 0 || empty($nombre) || $edad <= 0 || empty($genero)) {
        throw new Exception("Datos incompletos o inválidos");
    }

    // Verificar si tiene acceso al examen
    $stmt_check = safe_prepare($conn, "SELECT 1 FROM usuario_examen WHERE usuario_id = ? AND examen_id = ? AND activo = 1");
    $stmt_check->bind_param("ii", $usuario_id, $examen_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("El examen no está activo o autorizado para este usuario.");
    }
    $stmt_check->close();

    // Recoger respuestas
    $respuestas = [];
    for ($i = 1; $i <= 30; $i++) {
        $clave = 'P' . $i;
        $respuestas[$clave] = isset($_POST[$clave]) ? (int)$_POST[$clave] : 0;
    }

    // Calcular puntaje
    $puntaje_total = calcularPuntajePRP($respuestas, $respuestasRojas);
    $resultado = evaluarPuntajePRP($puntaje_total);

    // Insertar resultado en la tabla respuestas (solo el puntaje final)
    $stmt_insert = safe_prepare($conn, "INSERT INTO respuestas (usuario_id, examen_id, respuesta, fecha) VALUES (?, ?, ?, NOW())");
    $stmt_insert->bind_param("iii", $usuario_id, $examen_id, $puntaje_total);
    if (!$stmt_insert->execute()) {
        throw new Exception("Error al guardar el puntaje: " . $stmt_insert->error);
    }
    $stmt_insert->close();

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

    // Marcar examen como completado
    $stmt_update = safe_prepare($conn, "UPDATE usuario_examen SET completado = 1, activo = 0 WHERE usuario_id = ? AND examen_id = ?");
    $stmt_update->bind_param("ii", $usuario_id, $examen_id);
    if (!$stmt_update->execute()) {
        throw new Exception("Error al actualizar estado del examen: " . $stmt_update->error);
    }
    $stmt_update->close();

    // Redirigir a vista de resultados
    header("Location: ../examenes.php?success=1");
    exit();

} catch (Exception $e) {
    header("Location: ../examenes.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>
