<?php
session_start();
include 'config/config.php';
include 'config/auth.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examen_id = $_POST['examen_id'];
    $nuevo_estado = $_POST['estado'] === 'activo' ? 'inactivo' : 'activo';

    $stmt = $conn->prepare("UPDATE examenes SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevo_estado, $examen_id);
    $stmt->execute();
    $stmt->close();

    header("Location: panel.php");
    exit();
}
?>
