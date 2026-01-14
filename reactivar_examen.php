<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'psicologo') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['usuario_id'], $_POST['reactivar_examen'])) {
    $usuario_id = $_POST['usuario_id'];
    $examen_id = $_POST['reactivar_examen'];
    
    try {
        // Reactivar el examen y marcar como no completado
        $stmt = $conn->prepare("UPDATE usuario_examen SET activo = 1, completado = 0 WHERE usuario_id = ? AND examen_id = ?");
        $stmt->bind_param("ii", $usuario_id, $examen_id);
        $stmt->execute();
        
        // Eliminar resultados previos
        $stmt = $conn->prepare("DELETE FROM resultados WHERE usuario_id = ? AND examen_id = ?");
        $stmt->bind_param("ii", $usuario_id, $examen_id);
        $stmt->execute();
        
        $_SESSION['success'] = "Examen reactivado correctamente. El usuario puede volver a realizarlo.";
    } catch (Exception $e) {
        $_SESSION['error'] = "Error al reactivar el examen: " . $e->getMessage();
    }
    
    header("Location: panel.php");
    exit();
}
?>