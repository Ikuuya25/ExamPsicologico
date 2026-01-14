<?php
include '../config/config.php'; // Incluir la configuración de la base de datos


// Obtener el ID del psicólogo a editar
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$id_psicologo = $_GET['id'];

// Obtener los datos del psicólogo desde la base de datos
$sql = "SELECT id, nombre, ot FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_psicologo);
$stmt->execute();
$result = $stmt->get_result();
$psicologo = $result->fetch_assoc();

if (!$psicologo) {
    header('Location: index.php');
    exit();
}

// Manejar la actualización de los datos del psicólogo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_psicologo'])) {
    $nombre = $_POST['nombre'];
    $ot = $_POST['ot'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE usuarios SET nombre = ?, ot = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $ot, $id_psicologo);

    if ($stmt->execute()) {
        $mensaje = "Psicólogo actualizado exitosamente.";
    } else {
        $error = "Error al actualizar el psicólogo.";
    }

    // Actualizar los datos mostrados
    $psicologo['nombre'] = $nombre;
    $psicologo['ot'] = $ot;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Psicólogo - PrevenirSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Editar Psicólogo</h1>
        <a href="../admin.php" class="btn btn-secondary mb-4">Volver a la lista</a>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $psicologo['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ot">OT:</label>
                <input type="text" id="ot" name="ot" class="form-control" value="<?php echo $psicologo['ot']; ?>" required>
            </div>
            <button type="submit" name="actualizar_psicologo" class="btn btn-primary mt-3">Actualizar Psicólogo</button>
        </form>
    </div>
</body>
</html>