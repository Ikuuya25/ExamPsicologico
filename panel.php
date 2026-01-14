<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado y es un psicólogo
if (!isset($_SESSION['id'])) {
    header("Location: ./index.php"); // Redirige a la página de inicio de sesión
    exit();
}

if ($_SESSION['rol'] !== 'psicologo') {
    header("Location: ../examenes.php"); // Redirigir si el rol no es psicólogo
    exit();
}

include 'config/config.php';

// Definir $fecha_hoy en el ámbito global
$fecha_hoy = date("Y-m-d");

function generarContrasena() {
    $fecha_actual = date("md");
    return "psalud" . $fecha_actual; // Ejemplo: psalud1025
}
$query = "
    SELECT e.id, e.nombre_examen, COUNT(r.id) as total_pacientes
    FROM examenes e
    LEFT JOIN resultados r ON e.id = r.examen_id
    WHERE e.id IN (
        SELECT examen_id FROM usuario_examen 
        WHERE usuario_id = ? AND activo = 1
    )
    GROUP BY e.id
    ORDER BY e.nombre_examen
";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Psicologo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: white;
            color: black;
            padding: 15px;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
            transition: background-color 0.3s ease;
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
            background-color: #f8f9fa;
        }

        h1 {
            color: #1a3d7c;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #1a3d7c;
            color: white;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f0f0f0;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        .btn {
            background-color: #0056a3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #003d75;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        header {
            background-color: #1a3d7c;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        header img {
            height: 50px;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #1a3d7c;
            color: white;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f0f0f0;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        /* Estilos para el formulario */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container h3 {
            color: #1a3d7c;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group select:focus {
            border-color: #0056a3;
            outline: none;
        }

        .btn {
            background-color: #0056a3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #003d75;
        }

        .btn-primary {
            background-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
        }
        .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .examenes-checkbox {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Dos columnas */
            gap: 10px; /* Espacio entre elementos */
        }

        .checkbox-item {
            display: flex;
            align-items: center; /* Alinea verticalmente el checkbox y el texto */
            margin-bottom: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 8px; /* Espacio entre el checkbox y el texto */
        }

        .checkbox-item label {
            font-size: 14px;
            color: #333;
            margin: 0; /* Elimina el margen predeterminado del label */
        }
        .btn-success {
            background-color: #28a745;
            padding: 5px 10px;
            font-size: 12px;
            margin-left: 10px;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li onclick="location.href='index.php'"><i class="fa fa-home"></i> Inicio</li>
            <li onclick="location.href='panel.php'"><i class="fa fa-cogs"></i>Panel</li>
            <li onclick="location.href='examenes.php'"><i class="fa fa-edit"></i>Exámenes</li>
            <li onclick="location.href='admin.php'"><i class="fa fa-user"></i>Información Usuarios</li>
            <li onclick="location.href='config/logout.php'"><i class="fa fa-bars"></i>Cerrar sesión</li>
        </ul>
    </div>

    <div class="content">
        <h2>Usuarios del Día</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>OT</th>
                    <th>Examen Asignado</th>
                    <th>Asignación</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $fecha_hoy = date("Y-m-d");
            $stmt = $conn->prepare("
                SELECT u.id, u.nombre, u.ot, 
                    GROUP_CONCAT(CASE WHEN ue.activo = 1 THEN e.nombre_examen ELSE NULL END SEPARATOR ', ') AS examenes_asignados,
                    GROUP_CONCAT(CASE WHEN ue.activo = 1 THEN e.id ELSE NULL END SEPARATOR ',') AS examenes_ids,
                    GROUP_CONCAT(CASE WHEN ue.activo = 0 THEN e.id ELSE NULL END SEPARATOR ',') AS examenes_inactivos_ids,
                    GROUP_CONCAT(CASE WHEN ue.activo = 0 THEN e.nombre_examen ELSE NULL END SEPARATOR ', ') AS examenes_inactivos_nombres
                FROM usuarios u
                LEFT JOIN usuario_examen ue ON u.id = ue.usuario_id
                LEFT JOIN examenes e ON ue.examen_id = e.id
                WHERE DATE(u.fecha_registro) = ? AND u.rol != 'psicologo'
                GROUP BY u.id
            ");
            $stmt->bind_param("s", $fecha_hoy);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) { 
                // Convertir los IDs de exámenes asignados a un array
                $examenes_asignados_ids = !empty($row['examenes_ids']) ? explode(',', $row['examenes_ids']) : array();
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['ot']) ?></td>
                    <td>
                        <?= !empty($row['examenes_asignados']) ? htmlspecialchars($row['examenes_asignados']) : "Sin asignar" ?>
                    </td>
                    <td>
                        <form method="POST" action="asignar_examen.php" class="form-asignar">
                            <input type="hidden" name="usuario_id" value="<?= $row['id'] ?>">
                            <div class="examenes-checkbox">
                                <?php
                                $examenes = $conn->query("SELECT id, nombre_examen FROM examenes");
                                $examenes_inactivos_ids = !empty($row['examenes_inactivos_ids']) ? explode(',', $row['examenes_inactivos_ids']) : array();
                                
                                while ($examen = $examenes->fetch_assoc()) { 
                                    $estaAsignado = in_array($examen['id'], $examenes_asignados_ids);
                                    $estaInactivo = in_array($examen['id'], $examenes_inactivos_ids);
                                    ?>
                                    <div class="checkbox-item">
                                        <input type="checkbox" 
                                            name="examenes[]" 
                                            value="<?= $examen['id'] ?>" 
                                            id="examen_<?= $examen['id'] ?>_<?= $row['id'] ?>"
                                            <?= $estaAsignado ? 'disabled checked' : '' ?>
                                            <?= $estaInactivo ? '' : '' ?>>
                                        <label for="examen_<?= $examen['id'] ?>_<?= $row['id'] ?>" 
                                            style="<?= $estaAsignado ? 'color: #999;' : '' ?>">
                                            <?= htmlspecialchars($examen['nombre_examen']) ?>
                                        </label>
                                        <?php if ($estaInactivo): ?>
                                            <button type="submit" formaction="reactivar_examen.php" 
                                                    name="reactivar_examen" value="<?= $examen['id'] ?>"
                                                    class="btn btn-sm btn-success">
                                                Reactivar
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-asignar">Asignar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
        <!-- Formulario para agregar nuevos usuarios -->
        <div class="form-container">
            <h3>Agregar Nuevo Usuario</h3>
                <form method="POST" action="agregar_usuario.php">
                <div class="form-group">
                    <label for="nombre">Nombre Completo: <span class="required">*</span></label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ot">OT: <span class="required">*</span></label>
                    <input type="text" id="ot" name="ot" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña: <span class="required">*</span></label>
                    <input type="text" id="password" name="password" class="form-control" value="<?= generarContrasena() ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="examen_asignado">Asignar Examen: <span class="required">*</span></label>
                    <div class="examenes-checkbox">
                        <?php
                        $examenes = $conn->query("SELECT id, nombre_examen FROM examenes");
                        while ($examen = $examenes->fetch_assoc()) { ?>
                            <div class="checkbox-item">
                                <input type="checkbox" name="examenes[]" value="<?= $examen['id'] ?>" id="examen_<?= $examen['id'] ?>">
                                <label for="examen_<?= $examen['id'] ?>"><?= htmlspecialchars($examen['nombre_examen']) ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
                <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Exámenes Disponibles</h2>
        </div>

            <div class="row g-4">
                <?php foreach ($examenes as $examen): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="exam-card p-4 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="mb-3"><?php echo htmlspecialchars($examen['nombre_examen']); ?></h5>
                            </div>
                            <div class="d-grid">
                                <a href="buscar_pacientes.php?examen_id=<?php echo $examen['id']; ?>" 
                                class="btn btn-primary">
                                <i class="fas fa-users me-2"></i> Ver Pacientes
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>