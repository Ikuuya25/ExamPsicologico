<?php
include 'config/config.php';
include 'config/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre_examen'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO examenes (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Examen agregado correctamente'); window.location.href='panel.php';</script>";
}
?>

<form method="POST">
    <label>Nombre del Examen:</label>
    <input type="text" name="nombre_examen" required>
    
    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>
    
    <button type="submit">Agregar Examen</button>
</form>
