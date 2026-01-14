<?php
session_start();

// Verifica si la sesión está iniciada y si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ./index.php");
    exit();
}

// Obtiene la página actual (sin parámetros GET)
$current_page = basename($_SERVER['PHP_SELF']);

// Verifica el tipo de usuario y redirige solo si no está en la página correcta
if (isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 'psicologo':
            if ($current_page != 'panel.php') {
                header("Location: ./panel.php");
                exit();
            }
            break;
            
        case 'usuario':
            if ($current_page != 'examenes.php') {
                header("Location: examenes.php");
                exit();
            }
            break;
            
        default:
            // Si el rol no es reconocido, cierra sesión
            session_destroy();
            header("Location: ./index.php");
            exit();
    }
} else {
    // Si no hay rol definido, cierra sesión
    session_destroy();
    header("Location: ./index.php");
    exit();
}
?>