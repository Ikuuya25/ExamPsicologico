<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ot = trim($_POST['ot'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validar que los campos no estén vacíos
    if (empty($ot) || empty($password)) {
        die("Por favor, complete todos los campos.");
    }

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT id, nombre, ot, rol, password FROM usuarios WHERE ot = ?");
    $stmt->bind_param("s", $ot);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Guardar datos en la sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['ot'] = $row['ot'];
            $_SESSION['rol'] = $row['rol'];

            // Redirección según el rol
            switch ($row['rol']) {
                case 'usuario':
                    header("Location: ../examenes.php");
                    exit();
                case 'psicologo':
                    header("Location: ../panel.php");
                    exit();
                default:
                    die("Rol no reconocido.");
            }
        } else {
            die("Contraseña incorrecta.");
        }
    } else {
        die("Usuario no encontrado.");
    }
}
