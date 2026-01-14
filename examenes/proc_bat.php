<?php
session_start();
include "../config/config.php";

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    die("<script>alert('Error de conexión a la base de datos'); window.location.href = '../examenes.php';</script>");
}

try {
    // Validar que los datos estén presentes
    $required_fields = ['nombre', 'edad', 'genero'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Error: El campo $field es requerido.");
        }
    }

    // Sanitizar y validar datos
    $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $edad = filter_var($_POST['edad'], FILTER_SANITIZE_NUMBER_INT);
    $genero = htmlspecialchars(trim($_POST['genero']), ENT_QUOTES, 'UTF-8');
    $examen_id = 3; // ID fijo para el examen de Barrat

    if (!is_numeric($edad) || $edad < 0 || $edad > 120) {
        throw new Exception("Error: Edad no válida (debe ser entre 0 y 120).");
    }

    // Iniciar transacción para asegurar integridad de los datos
    $conn->begin_transaction();

    // Insertar datos del paciente en la tabla `resultados`
    $sql = "INSERT INTO resultados (examen_id, nombre_paciente, edad, genero, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("isis", $examen_id, $nombre, $edad, $genero);
    if (!$stmt->execute()) {
        throw new Exception("Error al guardar los datos del paciente: " . $stmt->error);
    }
    $resultado_id = $stmt->insert_id;
    $stmt->close();

    // Insertar respuestas del paciente
    $sql = "INSERT INTO respuestas_paciente (resultado_id, pregunta_id, respuesta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta de respuestas: " . $conn->error);
    }

    $respuestas_guardadas = 0;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'pregunta') === 0) {
            $pregunta_id = filter_var(str_replace('pregunta', '', $key), FILTER_SANITIZE_NUMBER_INT);
            $respuesta = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            
            // Validar que la respuesta sea un número entre 0 y 3 (para Barrat)
            if ($respuesta < 0 || $respuesta > 3) {
                $conn->rollback();
                throw new Exception("Error: Respuesta inválida para la pregunta $pregunta_id");
            }

            $stmt->bind_param("iii", $resultado_id, $pregunta_id, $respuesta);
            if (!$stmt->execute()) {
                $conn->rollback();
                throw new Exception("Error al guardar la respuesta $pregunta_id: " . $stmt->error);
            }
            $respuestas_guardadas++;
        }
    }
    $stmt->close();

    // Verificar que se hayan guardado todas las respuestas esperadas (30 para Barrat)
    if ($respuestas_guardadas < 30) {
        $conn->rollback();
        throw new Exception("Error: No se recibieron todas las respuestas necesarias.");
    }

    // Marcar el examen como completado
    $usuario_id = $_SESSION['id'];
    $sql = "UPDATE usuario_examen SET completado = 1, fecha_completado = NOW() WHERE usuario_id = ? AND examen_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $conn->rollback();
        throw new Exception("Error al preparar la actualización de estado: " . $conn->error);
    }
    $stmt->bind_param("ii", $usuario_id, $examen_id);
    if (!$stmt->execute()) {
        $conn->rollback();
        throw new Exception("Error al marcar el examen como completado: " . $stmt->error);
    }
    $stmt->close();

    // Confirmar todos los cambios
    $conn->commit();

    // Mensaje de éxito y redirección
    $_SESSION['mensaje_exito'] = "El cuestionario de Barrat se envió correctamente.";
    header("Location: ../examenes.php");
    exit();

} catch (Exception $e) {
    if (isset($conn) && $conn->in_transaction) {
        $conn->rollback();
    }
    $_SESSION['mensaje_error'] = $e->getMessage();
    header("Location: ../examenes.php");
    exit();
} finally {
    if (isset($stmt) && $stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
