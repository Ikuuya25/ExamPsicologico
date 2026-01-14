<?php
include 'config/auth.php';

// Verificar si el usuario está autenticado y es un usuario normal
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); // Redirigir a la página de inicio de sesión
    exit();
}

if ($_SESSION['rol'] !== 'usuario') {
    header("Location: index.php"); // Redirigir si el rol no es usuario
    exit();
}

include 'config/config.php'; // Aquí se define $conn

// Obtener el ID del usuario desde la sesión
$usuario_id = $_SESSION['id'];

// Consulta para obtener los exámenes asignados al usuario
$stmt = $conn->prepare("
    SELECT e.id, e.nombre_examen 
    FROM examenes e
    JOIN usuario_examen ue ON e.id = ue.examen_id
    WHERE ue.usuario_id = ?
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Almacenar los exámenes asignados en un array
$examenes_asignados = [];
while ($row = $result->fetch_assoc()) {
    $examenes_asignados[] = $row['nombre_examen'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámenes Psicológicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS (sin cambios) */
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li onclick="location.href='index.php'"><i class="fa fa-home"></i> Inicio</li>
            <li onclick="location.href='panel.php'"><i class="fa fa-cogs"></i>Panel</li>
            <li onclick="location.href='examenes.php'"><i class="fa fa-edit"></i>Exámenes</li>
            <li onclick="location.href='admin.php'"><i class="fa fa-user"></i>Información Usuarios</li>
            <li><i class="fa fa-bars"></i>Menú</li>
        </ul>
    </div>
    <div class="content">
        <h2>Seleccione un Examen</h2>
        <div class="exam-list">
            <?php
            // Lista de todos los exámenes disponibles con sus rutas
            $todos_los_examenes = [
                'PRP' => 'examenes/prp.php',
                'Barrat' => 'examenes/barrat.php',
                'Epworth' => 'examenes/epworth.php',
                'EPQ' => 'examenes/epq.php',
                'Pittsburgh' => 'examenes/pittsburgh.php',
            ];

            // Mostrar solo los exámenes asignados al usuario
            foreach ($todos_los_examenes as $nombre_examen => $url) {
                if (in_array($nombre_examen, $examenes_asignados)) {
                    echo "<div class='exam-card' onclick=\"window.location.href='$url'\">$nombre_examen</div>";
                }
            }

            // Si no hay exámenes asignados, mostrar un mensaje
            if (empty($examenes_asignados)) {
                echo "<p>No tienes exámenes asignados.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>