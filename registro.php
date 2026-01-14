<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registro de Usuario</h2>
        <form action="config/signin.php" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ot" class="form-label">Orden de Trabajo (OT):</label>
                <input type="text" id="ot" name="ot" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Tipo de Usuario:</label>
                <select id="rol" name="rol" class="form-control" required>
                    <option value="usuario">Usuario</option>
                    <option value="psicologo">Psicólogo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>
</body>
</html>
