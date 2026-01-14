<?php
include '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $ot = $_POST['ot'];
    $examen_asignado = $_POST['examen_asignado'];

    $sql = "INSERT INTO usuarios (nombre, ot, examen_asignado, rol) VALUES (?, ?, ?, 'psicologo')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $ot, $examen_asignado);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "Error al agregar el psicólogo.";
    }
}