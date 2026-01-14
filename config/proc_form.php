<?php
$serverName = "IKUUYA";// Servidor SQL
$database = "Publico";// Base de datos
$username = "sa";// Usuario de SQL Server
$password = "1234";// Contraseña

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $edad = $_POST['edad'] ?? '';
        $genero = $_POST['genero'] ?? '';
    
    echo "Conexión exitosa.";
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
    // Validación de datos
    if (empty($nombre) || empty($edad) || empty($genero)) {
        throw new Exception("Todos los campos son obligatorios.");
    }
    // Inserta datos
    $sql = "INSERT INTO epworth (nombre, edad, genero) VALUES (:nombre, :edad, :genero)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt->bindParam(':genero', $genero);

    $stmt->execute();

    echo "Datos ingresados correctamente.";
