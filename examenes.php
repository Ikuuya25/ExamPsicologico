<?php
include 'config/auth.php';
// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Incluir la configuración de la base de datos
include 'config/config.php'; // Aquí se define $conn


// Obtener el ID del usuario desde la sesión
$usuario_id = $_SESSION['id'];

// Consultar los exámenes asignados al usuario y su estado
$query = "
    SELECT e.id, e.nombre_examen, 
           IFNULL(ue.completado, 0) as completado, 
           IFNULL(ue.activo, 1) as activo
    FROM examenes e
    JOIN usuario_examen ue ON e.id = ue.examen_id 
    WHERE ue.usuario_id = ? AND ue.activo = 1
";

// Preparar la consulta
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular el parámetro
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

// Obtener los resultados
$result = $stmt->get_result();
$examenes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: white;
            color: black;
            padding: 15px;
            border-right: 1px solid #ddd;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 16px;
        }
        .sidebar ul li i {
            margin-right: 8px;
            font-size: 14px;
        }
        .sidebar ul li:hover {
            background-color: #f0f0f0;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .exam-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .exam-card {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .exam-card:hover {
            transform: scale(1.05);
        }
        .disabled-card {
            opacity: 0.7;
            cursor: not-allowed;
            background-color: #f8f9fa;
        }

        .disabled-card:hover {
            transform: none !important;
        }

        .badge {
            font-size: 0.9em;
            padding: 5px 10px;
            border-radius: 50px;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li onclick="location.href='index.php'"><i class="fa fa-home"></i> Inicio</li>
            <li onclick="location.href='config/logout.php'"><i class="fa fa-bars"></i> Cerrar sesión</li>
        </ul>
    </div>

    <div class="content">
        <h2>Exámenes Asignados</h2>
        <div class="exam-list">
        <?php foreach ($examenes as $examen): 
            $archivo_examen = strtolower(preg_replace('/[^a-z0-9]/i', '-', $examen['nombre_examen']));
            $puede_realizar = (!$examen['completado'] && $examen['activo']);
        ?>
        <div class="exam-card <?php echo !$puede_realizar ? 'disabled-card' : ''; ?>"
            onclick="<?php echo $puede_realizar ? "location.href='examenes/{$archivo_examen}.php?examen_id={$examen['id']}'" : ''; ?>">
            <h3><?php echo htmlspecialchars($examen['nombre_examen']); ?></h3>
            <p>
                <?php if ($examen['completado']): ?>
                    <span class="badge bg-secondary">Completado</span>
                <?php elseif (!$examen['activo']): ?>
                    <span class="badge bg-danger">Inactivo</span>
                <?php else: ?>
                    <span class="badge bg-success">Disponible</span>
                <?php endif; ?>
            </p>
            <?php if ($examen['completado']): ?>
                <small class="text-muted">Contacta al psicólogo para reactivarlo</small>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
</body>
</html>