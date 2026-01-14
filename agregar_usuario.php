<?php
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $ot = $_POST['ot'];
    $password = $_POST['password']; // Contraseña en texto plano
    $examenes = $_POST['examenes']; // Array de exámenes seleccionados

    // Hashear la contraseña
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la tabla `usuarios`
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, ot, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $ot, $password_hashed); // Usar la contraseña hasheada
    $stmt->execute();
    $usuario_id = $stmt->insert_id; // Obtener el ID del usuario recién insertado

    // Asignar los exámenes seleccionados al usuario
    if (!empty($examenes)) {
        foreach ($examenes as $examen_id) {
            if (!empty($examen_id)) {
                // Insertar en la tabla intermedia `usuario_examen`
                $stmt = $conn->prepare("INSERT INTO usuario_examen (usuario_id, examen_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $usuario_id, $examen_id);
                $stmt->execute();
            }
        }
    }

    // Redirigir o mostrar un mensaje de éxito
    header("Location: panel.php?success=1");
    exit();
}
?>