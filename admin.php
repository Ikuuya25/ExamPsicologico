<?php
include 'config/config.php'; // Incluir la configuración de la base de datos
include 'config/auth.php';

// Manejar el cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cambiar_password'])) {
    $nueva_password = $_POST['nueva_password'];
    $confirmar_password = $_POST['confirmar_password'];

    if ($nueva_password === $confirmar_password) {
        $hashed_password = password_hash($nueva_password, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $id_usuario);

        if ($stmt->execute()) {
            $mensaje = "Contraseña cambiada exitosamente.";
        } else {
            $error = "Error al cambiar la contraseña.";
        }
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}

// Obtener la lista de psicólogos desde la base de datos
$sql_psicologos = "SELECT id, nombre, ot, examen_asignado FROM usuarios WHERE rol = 'psicologo'";
$result_psicologos = $conn->query($sql_psicologos);
$psicologos = [];
if ($result_psicologos->num_rows > 0) {
    while ($row = $result_psicologos->fetch_assoc()) {
        $psicologos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - PrevenirSalud</title>
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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Administrador</h2>
        <ul>
            <li onclick="location.href='index.php'"><i class="fa fa-home"></i> Inicio</li>
            <li onclick="location.href='examenes.php'"><i class="fa fa-edit"></i> Exámenes</li>
            <li onclick="location.href='panel.php'"><i class="fa fa-home"></i> Panel</li>
        </ul>
    </div>
    <div class="container mt-4">
        <h1>Gestión de Psicólogos</h1>

        <!-- Formulario para agregar psicólogos -->
        <form method="POST" action="assets/agregar_psicologo.php">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
            <label for="ot">OT:</label>
            <input type="text" id="ot" name="ot" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-3">Agregar Psicólogo</button>
        </form>

        <!-- Lista de psicólogos -->
        <h2 class="mt-4">Lista de Psicólogos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>OT</th>
                    <th>Examen Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($psicologos as $psicologo): ?>
                    <tr>
                        <td><?php echo $psicologo['nombre']; ?></td>
                        <td><?php echo $psicologo['ot']; ?></td>
                        <td>
                            <a href="assets/editar_psicologo.php?id=<?php echo $psicologo['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="assets/eliminar_psicologo.php?id=<?php echo $psicologo['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulario para cambiar la contraseña -->
        <h2 class="mt-4">Cambiar Contraseña</h2>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nueva_password">Nueva Contraseña:</label>
                <input type="password" id="nueva_password" name="nueva_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirmar_password">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required>
            </div>
            <button type="submit" name="cambiar_password" class="btn btn-primary mt-3">Cambiar Contraseña</button>
        </form>
    </div>
</body>
</html>