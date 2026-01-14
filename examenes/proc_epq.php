<?php
session_start();
include "../config/config.php";

// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para preparar consultas de forma segura
function safe_prepare($conn, $query) {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error al preparar consulta: " . $conn->error);
    }
    return $stmt;
}

// Función para calcular puntaje de neuroticismo
function calcularNeuroticismo($respuestas) {
    $items_neuroticismo = [3, 5, 9, 14, 19, 20, 21, 25, 33, 36, 42, 43, 53, 55, 63, 65, 71, 72, 74, 75, 77, 79, 81];
    $puntaje = 0;
    foreach ($items_neuroticismo as $item) {
        $puntaje += $respuestas['p'.$item] ?? 0;
    }
    return $puntaje;
}

// Función para calcular puntaje de psicoticismo
function calcularPsicoticismo($respuestas) {
    $items_psicoticismo = [1, 9, 15, 17, 23, 26, 29, 34, 37, 40, 44, 48, 50, 55, 59, 61, 63, 66, 67, 71, 74, 80];
    $puntaje = 0;
    foreach ($items_psicoticismo as $item) {
        $puntaje += $respuestas['p'.$item] ?? 0;
    }
    return $puntaje;
}

try {
    if (empty($_SESSION['id'])) {
        throw new Exception("Debe iniciar sesión primero");
    }

    // Obtener y validar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);
    $genero = $_POST['genero'] ?? '';
    $examen_id = (int)($_POST['examen_id'] ?? 0);
    $usuario_id = (int)$_SESSION['id'];

    if ($examen_id <= 0 || empty($nombre) || $edad <= 0 || empty($genero)) {
        throw new Exception("Datos incompletos o inválidos");
    }

    // Verificar si el usuario tiene acceso activo al examen
    $stmt_check = safe_prepare($conn, "SELECT 1 FROM usuario_examen WHERE usuario_id = ? AND examen_id = ? AND activo = 1");
    $stmt_check->bind_param("ii", $usuario_id, $examen_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("El examen no está activo o autorizado para este usuario.");
    }
    $stmt_check->close();

    // Insertar en tabla resultados
    $stmt_insert_resultado = safe_prepare($conn, "INSERT INTO resultados (examen_id, usuario_id, nombre_paciente, edad, genero, fecha) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt_insert_resultado->bind_param("iisis", $examen_id, $usuario_id, $edad, $genero);
    if (!$stmt_insert_resultado->execute()) {
        throw new Exception("Error al guardar en resultados: " . $stmt_insert_resultado->error);
    }
    $stmt_insert_resultado->close();

    // Obtener respuestas
    $respuestas = [];
    for ($i = 1; $i <= 83; $i++) {
        $respuestas['p'.$i] = isset($_POST['p'.$i]) ? (int)$_POST['p'.$i] : 0;
    }

    // Calcular puntajes
    $neuroticismo = calcularNeuroticismo($respuestas);
    $psicoticismo = calcularPsicoticismo($respuestas);
    $puntaje_total = $neuroticismo + $psicoticismo;

    // Insertar en tabla respuestas
    $stmt_insert_respuestas = safe_prepare($conn, "INSERT INTO respuestas (usuario_id, examen_id, respuesta, neuroticismo, psicoticismo, fecha) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt_insert_respuestas->bind_param("iiiii", $usuario_id, $examen_id, $puntaje_total, $neuroticismo, $psicoticismo);
    if (!$stmt_insert_respuestas->execute()) {
        throw new Exception("Error al guardar respuestas: " . $stmt_insert_respuestas->error);
    }
    $stmt_insert_respuestas->close();

    // Marcar examen como completado
    $stmt_update = safe_prepare($conn, "UPDATE usuario_examen SET completado = 1, activo = 0 WHERE usuario_id = ? AND examen_id = ?");
    $stmt_update->bind_param("ii", $usuario_id, $examen_id);
    if (!$stmt_update->execute()) {
        throw new Exception("Error al actualizar estado del examen: " . $stmt_update->error);
    }
    $stmt_update->close();

    // Redirigir a la vista de exámenes con mensaje de éxito
    header("Location: ../examenes.php?success=1");
    exit();

} catch (Exception $e) {
    header("Location: ../examenes.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>
