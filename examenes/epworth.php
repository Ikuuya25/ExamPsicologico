<?php
session_start();
include "../config/config.php";
    $preguntas = [
        "Sentado y leyendo",
        "Viendo televisión",
        "Sentado inactivo en un lugar publico",
        "En auto, como pasajero una hora sin descansar",
        "Recostado descansando en la tarde, cuando las circunstancias lo permiten",
        "Sentado y conversando con alguien",
        "Sentado y tranquilo después de almuerzo (sin tomar alcohol).",
        "En auto, detenido por unos minutos por el tráfico."
    ];
    $opciones = [
        0 => "Sin posibilidad de cabecear o dormirse",
        1 => "Ligera posibilidad de cabecear o dormirse", 
        2 => "Moderada posibilidad de cabecear o dormirse",
        3 => "Alta posibilidad de cabecear o dormirse"
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escala de Epworth - PrevenirSalud</title>
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
            margin-bottom: 20px;
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
    <div class="content">
    <!-- Recuadro de instrucciones -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h2>Escala de Epworth</h2>
            <div class="alert alert-info">
                <h4>Instrucciones:</h4>
                <p><strong>Para cada enunciado debe responder la siguiente pregunta:</strong></p>
                <p>¿Qué tan probable es que usted se sienta somnoliento, "cabecee" o se quede dormido en las siguientes situaciones, diferenciando de sólo sentirse cansado?</p>
                <p class="mb-0">Esto se refiere a su vida habitual durante el último tiempo, aunque no haya realizado recientemente algunas de las siguientes actividades, póngase en la situación de cómo le afectarían. Use la siguiente escala y elija la opción más adecuada para cada situación.</p>
            </div>
            <p class="mt-3">Marque la alternativa que considere correcta.</p>
        </div>
    </div>

    <!-- Formulario del cuestionario -->
    <div class="card shadow">
        <div class="card-body">
            <form id="epworth-form" action="proc_epworth.php" method="POST">
                <!-- Sección de datos personales -->
                <div class="mb-4">
                    <h3>Datos del Paciente</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre Completo:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edad">Edad:</label>
                                <input type="number" id="edad" name="edad" class="form-control" min="1" max="120" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="genero">Género:</label>
                                <select id="genero" name="genero" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                            <input type="hidden" name="examen_id" value="<?= isset($_GET['examen_id']) ? htmlspecialchars($_GET['examen_id']) : '' ?>">
                    </div>
                </div>
        <?php
        $preguntas = [
            "Sentado y leyendo:",
            "Viendo televisión:",
            "Sentado inactivo en un lugar público:",
            "En auto, como pasajero una hora sin descansar:",
            "Recostado descansando en la tarde, cuando las circunstancias lo permiten:",
            "Sentado y conversando con alguien:",
            "Sentado y tranquilo después de almuerzo (sin tomar alcohol):",
            "En auto, detenido por unos minutos por el tráfico:"
        ];

        foreach ($preguntas as $index => $pregunta): ?>
            <div>
                <p></p>
                <label for="pregunta<?= $index + 1 ?>">Pregunta <?= $index + 1 ?>:</label>
                <p><?= $pregunta ?></p>
                <select class="form-control" name="pregunta<?= $index + 1 ?>" id="pregunta<?= $index + 1 ?>" required>
                    <option value="0">Seleccione..</option>
                    <option value="0">Sin posibilidad de cabecear o dormirse.</option>
                    <option value="1">Ligera posibilidad de cabecear o dormirse.</option>
                    <option value="2">Moderada posibilidad de cabecear o dormirse.</option>
                    <option value="3">Alta posibilidad de cabecear o dormirse.</option>
                </select>
            </div>
        <?php endforeach; ?>
        <div class="form-group mt-4">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="autorizacion" name="autorizacion" required>
        <label class="form-check-label" for="autorizacion">
            Al enviar, conforme a lo dispuesto en la Ley 19.628, autorizo a PrevenirSalud para la utilización de los resultados de esta evaluación con el fin de generar informe y enviarlo a la empresa solicitante.
        </label>
    </div>
</div>

<button type="submit" class="btn btn-primary btn-lg">Enviar Test</button>
    </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
