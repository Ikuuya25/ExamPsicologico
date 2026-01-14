<?php
session_start();
include "../config/config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen de Barrat - PrevenirSalud</title>
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

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .form-container h2 {
            color: #1a3d7c;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 30px; /* Separación entre preguntas */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #0056a3;
            outline: none;
        }

        .form-group .radio-group,
        .form-group .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group .radio-group label,
        .form-group .checkbox-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group .radio-group input[type="radio"],
        .form-group .checkbox-group input[type="checkbox"] {
            margin: 0;
        }

        .btn {
            background-color: #0056a3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #003d75;
        }

        .required {
            color: red;
            margin-left: 5px;
        }

        /* Estilos adicionales para mejorar la apariencia */
        .form-container p {
            color: #666;
            margin-bottom: 20px;
        }

        .form-container .authorization {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .form-container .authorization label {
            font-weight: normal;
            color: #333;
        }

        /* Asegurar que el texto no esté justificado */
        body, .form-container, .form-group, label {
            text-align: left; /* Alinear el texto a la izquierda */
        }

        /* Estilos para los grupos de radio */
        .form-group .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group .radio-group label {
            display: flex;
            align-items: center; /* Alinear verticalmente el radio con el texto */
            gap: 8px; /* Espacio entre el radio y el texto */
            font-weight: normal;
            cursor: pointer;
        }

        .form-group .radio-group input[type="radio"] {
            margin: 0; /* Eliminar márgenes predeterminados */
            flex-shrink: 0; /* Evitar que el radio se reduzca */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li onclick="location.href='../examenes.php'"><i class="fa fa-edit"></i> Exámenes</li>
            <li onclick="location.href='../config/logout.php'"><i class="fa fa-bars"></i> Cerrar sesión</li>
        </ul>
    </div>
    <?php
$preguntas = [
    "Planifico mis tareas con cuidado",
    "Hago las cosas sin pensarlo:",
    "Casi nunca me tomo las cosas a pecho. (No me perturbo con Facilidad):",
    "Mis pensamientos pueden tener gran velocidad. (Tengo pensamientos que van muy rápido en mi mente):",
    "Planifico mis viajes con antelación:",
    "Soy una persona con autocontrol:",
    "Me concentro con facilidad. (Se me hace fácil concentrarme):",
    "Ahorro con regularidad:",
    "Se me hace difícil estar quieto por largos periodos de tiempo:",
    "Pienso las cosas cuidadosamente:",
    "Planifico para tener un trabajo fijo. (Me esfuerzo por asegurar que tendré dinero para pagar por mis gastos):",
    "Digo las cosas sin pensarlas:",
    "Me gusta pensar sobre problemas complicados. (Me gusta pensar sobre problemas complejos):",
    "Cambio de trabajo frecuentemente. (No me quedo en el mismo trabajo por largos periodos de tiempo):",
    "Actúo impulsivamente:",
    "Me aburro con facilidad tratando de resolver problemas en mi mente. (Me aburre pensar en algo por demasiado tiempo):",
    "Visito al médico y al dentista con regularidad:",
    "Hago las cosas en el momento en que se me ocurren:",
    "Soy una persona que piensa sin distraerse. (Puedo enfocar mi mente en una sola cosa por mucho tiempo):",
    "Cambio de vivienda a menudo. (Me mudo con frecuencia o no me gusta vivir en el mismo sitio por mucho tiempo):",
    "Compro cosas impulsivamente:",
    "Yo termino lo que empiezo:",
    "Camino y me muevo con rapidez:",
    "Resuelvo los problemas experimentando. (Resuelvo los problemas tratando una posible solución y viendo si funciona):",
    "Gasto efectivo o en crédito más de lo que gano. (Gasto más de lo que gano):",
    "Hablo rápido:",
    "Tengo pensamientos extraños cuando estoy pensando. (A veces tengo pensamientos irrelevantes cuando pienso):",
    "Me interesa más el presente que el futuro:",
    "Me siento inquieto en clases o charlas. (Me siento inquieto si tengo que oír a alguien hablar por un largo periodo de tiempo):",
    "Planifico para el futuro. (Me interesa más el futuro que el presente):",
];
?>
<div class="container">
    <h1>Examen Barrat</h1>
    <p>Complete el cuestionario seleccionando una opción para cada pregunta.</p>

    <form id="barrat-form" action="proc_barrat.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="edad">Edad:</label>
            <input type="text" id="edad" name="edad" required>
        </div>

        <div class="form-group">
            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
            <input type="hidden" name="examen_id" value="<?= isset($_GET['examen_id']) ? htmlspecialchars($_GET['examen_id']) : '' ?>">
        </div>

        <h2>Cuestionario</h2>
        <div id="preguntas-container">
            <?php foreach ($preguntas as $index => $pregunta): ?>
                <div class="form-group"> <!-- Añadir la clase form-group aquí -->
                    <label for="pregunta<?php echo $index + 1; ?>">Pregunta <?php echo $index + 1; ?>:</label>
                    <p><?php echo $pregunta; ?></p>
                    <select name="pregunta<?php echo $index + 1; ?>" id="pregunta<?php echo $index + 1; ?>" required>
                        <option value="0">Raramente o nunca</option>
                        <option value="1">Ocasionalmente</option>
                        <option value="3">A menudo</option>
                        <option value="4">Siempre o casi siempre</option>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="submit" class="btn">Enviar Test</button>
    </form>
</div>
</body>
</html>