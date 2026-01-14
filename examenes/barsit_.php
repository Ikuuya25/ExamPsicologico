<?php
session_start();
include "../config/config.php";
    // Definición de las preguntas del BARSIT (ejemplo)
    $preguntas = [
        "Pregunta 1: ¿Cuál es la figura que completa la serie?",
        "Pregunta 2: ¿Qué figura sigue en la secuencia?",
        "Pregunta 3: ¿Cuál es la pieza que falta?",
        "Pregunta 4: ¿Qué figura no corresponde con las demás?",
        "Pregunta 5: ¿Cuál es la figura que completa la analogía?",
        "Pregunta 6: ¿Qué figura sigue en el patrón?",
        "Pregunta 7: ¿Cuál es la pieza que completa el diseño?",
        "Pregunta 8: ¿Qué figura es diferente?",
        "Pregunta 9: ¿Cuál es la figura que completa la matriz?",
        "Pregunta 10: ¿Qué figura sigue en la progresión?",
        "Pregunta 11: ¿Cuál es la pieza que encaja correctamente?",
        "Pregunta 12: ¿Qué figura rompe el patrón?",
        "Pregunta 13: ¿Cuál es la figura que completa la serie lógica?",
        "Pregunta 14: ¿Qué figura sigue en la secuencia?",
        "Pregunta 15: ¿Cuál es la pieza que falta en el diseño?"
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test BARSIT - PrevenirSalud</title>
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

        /* Estilos para las imágenes de las preguntas */
        .question-image {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Estilos para las opciones de respuesta */
        .options-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .option-item {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .option-item input[type="radio"] {
            margin-right: 8px;
        }

        .option-figure {
            max-width: 80px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 8px;
        }

        /* Temporizador */
        .timer-container {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 18px;
            font-weight: bold;
            color: #1a3d7c;
            z-index: 1000;
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
                <h2>Test BARSIT</h2>
                <div class="alert alert-info">
                    <h4>Instrucciones:</h4>
                    <p><strong>Este test evalúa su capacidad para razonar y resolver problemas.</strong></p>
                    <p>El test consta de 15 preguntas con figuras. En cada pregunta deberá seleccionar la opción correcta que complete la serie, secuencia o patrón mostrado.</p>
                    <p class="mb-0">Tendrá un tiempo limitado para completar el test. Por favor, trabaje con rapidez y precisión.</p>
                </div>
                <p class="mt-3">Marque la alternativa que considere correcta para cada pregunta.</p>
            </div>
        </div>

        <!-- Formulario del cuestionario -->
        <div class="card shadow">
            <div class="card-body">
                <form id="barsit-form" action="proc_barsit.php" method="POST">
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
                                    <input type="number" id="edad" name="edad" class="form-control" min="18" max="120" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="escolaridad">Escolaridad:</label>
                                    <select id="escolaridad" name="escolaridad" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Basica">Básica</option>
                                        <option value="Media">Media</option>
                                        <option value="Tecnica">Técnica</option>
                                        <option value="Universitaria">Universitaria</option>
                                        <option value="Postgrado">Postgrado</option>
                                    </select>
                                </div>
                                <input type="hidden" name="examen_id" value="<?= isset($_GET['examen_id']) ? htmlspecialchars($_GET['examen_id']) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Temporizador -->
                    <div class="timer-container">
                        <i class="fas fa-clock"></i> Tiempo restante: <span id="timer">30:00</span>
                    </div>

                    <!-- Preguntas del BARSIT -->
                    <?php foreach ($preguntas as $index => $pregunta): ?>
                        <div class="question-group mb-4">
                            <h5><?= $pregunta ?></h5>
                            
                            <!-- Aquí iría la imagen de la pregunta (en un caso real) -->
                            <div class="question-image-placeholder bg-light p-4 text-center mb-3">
                                <p class="text-muted">[Imagen de la pregunta <?= $index + 1 ?>]</p>
                            </div>
                            
                            <div class="options-container">
                                <!-- Opciones de respuesta (normalmente serían imágenes) -->
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <div class="option-item">
                                        <input type="radio" id="pregunta<?= $index + 1 ?>_opcion<?= $i ?>" 
                                               name="pregunta<?= $index + 1 ?>" value="<?= $i ?>" required>
                                        <label for="pregunta<?= $index + 1 ?>_opcion<?= $i ?>">
                                            <div class="option-figure-placeholder bg-light p-2 text-center">
                                                <small class="text-muted">Opción <?= $i ?></small>
                                            </div>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <hr>
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

    <script>
        // Temporizador de 30 minutos (1800 segundos)
        let timeLeft = 1800;
        const timerElement = document.getElementById('timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert('¡Tiempo terminado! El test se enviará automáticamente.');
                document.getElementById('barsit-form').submit();
            } else {
                timeLeft--;
            }
        }
        
        const timerInterval = setInterval(updateTimer, 1000);
        
        // Validación antes de enviar
        document.getElementById('barsit-form').addEventListener('submit', function(e) {
            const unanswered = [];
            
            // Verificar que todas las preguntas estén respondidas
            <?php foreach ($preguntas as $index => $pregunta): ?>
                if (!document.querySelector('input[name="pregunta<?= $index + 1 ?>"]:checked')) {
                    unanswered.push(<?= $index + 1 ?>);
                }
            <?php endforeach; ?>
            
            if (unanswered.length > 0) {
                e.preventDefault();
                alert(`Por favor responda las siguientes preguntas: ${unanswered.join(', ')}`);
            }
            
            if (!document.getElementById('autorizacion').checked) {
                e.preventDefault();
                alert('Debe autorizar el uso de los resultados para continuar');
            }
        });
    </script>
</body>
</html>