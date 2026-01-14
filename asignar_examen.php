<?php
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $examenes = $_POST['examenes']; // Array de exámenes seleccionados

    // Asignar los nuevos exámenes al usuario
    if (!empty($examenes)) {
        foreach ($examenes as $examen_id) {
            if (!empty($examen_id)) {
                // Verificar si el examen ya está asignado al usuario
                $stmt = $conn->prepare("SELECT * FROM usuario_examen WHERE usuario_id = ? AND examen_id = ?");
                $stmt->bind_param("ii", $usuario_id, $examen_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    // Insertar en la tabla intermedia `usuario_examen`
                    $stmt = $conn->prepare("INSERT INTO usuario_examen (usuario_id, examen_id) VALUES (?, ?)");
                    $stmt->bind_param("ii", $usuario_id, $examen_id);
                    $stmt->execute();
                }
            }
        }
    }

    // Redirigir o mostrar un mensaje de éxito
    header("Location: panel.php?success=1");
    exit();
}
?>