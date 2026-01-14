<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $ot = $_POST['ot'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $check_stmt = $conn->prepare("SELECT id FROM usuarios WHERE ot = ?");
    $check_stmt->bind_param("s", $ot);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('Error: La OT ya está registrada.'); window.location.href='signin.php';</script>";
        exit();
    }
    $check_stmt->close();

    $stmt = $conn->prepare("INSERT INTO usuarios (ot, password, rol, nombre) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ot, $hashed_password, $rol, $nombre);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado exitosamente'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario'); window.location.href='config/signin.php';</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
