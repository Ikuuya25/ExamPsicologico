<?php
date_default_timezone_set('America/Santiago'); // Cambia 'America/Santiago' por tu zona horaria
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Usuario de MySQL (por defecto en XAMPP es 'root')
define('DB_PASS', ''); // Contraseña de MySQL (vacía por defecto en XAMPP)
define('DB_NAME', 'prevenirsalud');

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
