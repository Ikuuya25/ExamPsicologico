<?php
// Conectamos a la base de datos
include 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// OT que quieres probar (debes usar un OT existente en tu base de datos)
$ot_ingresado = '3'; // Cambia esto por el OT que usas para probar
$contraseña_ingresada = '3'; // Cambia esto por la contraseña que ingresaste

// Buscamos el usuario en la base de datos
$stmt = $conn->prepare("SELECT password FROM usuarios WHERE ot = ?");
$stmt->bind_param("s", $ot_ingresado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hash_en_bd = $row['password'];

    echo "Hash almacenado en BD: " . htmlspecialchars($hash_en_bd) . "<br>";

    // Verificamos la contraseña ingresada contra el hash
    if (password_verify($contraseña_ingresada, $hash_en_bd)) {
        echo "✅ ¡Contraseña válida!";
    } else {
        echo "❌ Contraseña incorrecta.";
    }
} else {
    echo "❌ Usuario no encontrado.";
}

$stmt->close();
$conn->close();

