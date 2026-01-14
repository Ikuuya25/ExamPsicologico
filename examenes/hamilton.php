<?php
session_start();
include "../config/config.php";

$preguntas = [
    "Preocupaciones, temor de que suceda lo peor, temor anticipado, irritabilidad.",
    "Sensaciones de tensión, fatigabilidad, sobresalto al responder, llanto fácil.",
    "Temores: A la oscuridad, a los desconocidos, a quedarse solo, a los animales grandes, al tráfico, a las multitudes.",
    "Dificultad para dormirse, sueño interrumpido, sueño insatisfactorio y fatiga al despertar, pesadillas, terrores nocturnos.",
    "Alteraciones intelectuales (cognitivas): Dificultad para concentrarse, mala memoria.",
    "Estado de ánimo depresivo: Pérdida de interés, falta de placer en los pasatiempos, depresión, despertar precoz, cambios de humor a lo largo del día.",
    "Síntomas somáticos generales (musculares): Dolores musculares, rigidez muscular, contracciones musculares, sacudidas clónicas, crujir de dientes, voz temblorosa.",
    "Síntomas somáticos generales (sensoriales): Zumbidos de oídos, visión borrosa, sofocaciones, sensación de debilidad, sensación de inestabilidad.",
    "Síntomas cardiovasculares: Taquicardia, palpitaciones, dolor en el pecho, latidos vasculares, sensación de desmayo, extrasístoles.",
    "Síntomas respiratorios: Opresión o constricción en el pecho, sensación de ahogo, suspiros, disnea.",
    "Síntomas gastrointestinales: Dificultad para tragar, gases, dispepsia, dolor antes o después de las comidas, sensación de ardor, sensación de estómago lleno, vómitos acuosos, vientre suelto, pérdida de peso, estreñimiento.",
    "Síntomas genitourinarios: Micción frecuente, micción urgente, amenorrea, menorragia, aparición de frigidez, eyaculación precoz, impotencia.",
    "Síntomas autónomos: Boca seca, rubor, palidez, tendencia a sudar, vértigos, cefaleas de tensión, piloerección.",
    "Conducta durante la entrevista: Inquietud, impaciencia, temblores, tensión facial, suspiros, palidez facial, deglución, eructos, tics, etc."
    ];
    $opciones = ["Ausente", "Leve", "Moderado", "Grave", "Muy grave"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['nombre']) || !isset($_POST['edad']) || !isset($_POST['genero'])) {
        die("Error: Datos incompletos.");
    }

    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $edad = filter_var($_POST['edad'], FILTER_SANITIZE_NUMBER_INT);
    $genero = htmlspecialchars($_POST['genero'], ENT_QUOTES, 'UTF-8');

    if (!is_numeric($edad) || $edad < 0 || $edad > 120) {
        die("Error: Edad no válida.");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Hamilton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin-bottom: 20px; /* Separación entre preguntas */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group .radio-group {
            display: flex;
            gap: 15px;
        }

        .form-group .radio-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group .radio-group input[type="radio"] {
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
            width: 100%;
        }

        .btn:hover {
            background-color: #003d75;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul class="list-unstyled">
            <li class="mb-2"><a href="../examenes.php" class="text-decoration-none">Exámenes</a></li>
            <li><a href="../config/logout.php" class="text-decoration-none">Cerrar sesión</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Test de Hamilton</h2>
                
                <form method="POST" action="proc_hamilton.php">
                    <!-- Datos del paciente -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Nombre completo:</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Edad:</label>
                            <input type="number" name="edad" class="form-control" min="1" max="120" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Rut (12345678-9):</label>
                            <input type="number" name="rut" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Género:</label>
                            <select name="genero" class="form-select" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                        <input type="hidden" name="examen_id" value="<?= isset($_GET['examen_id']) ? htmlspecialchars($_GET['examen_id']) : '' ?>">
                    </div>

                    <?php foreach ($preguntas as $indice => $pregunta): ?>
                        <div class="mb-4 p-3 border rounded bg-light">
                            <p class="fw-bold mb-3"><?= ($indice + 1) ?>. <?= $pregunta ?></p>
                            <div class="ps-3">
                                <div class="btn-group-vertical w-100" role="group" aria-label="Opciones para pregunta <?= $indice + 1 ?>">
                                    <?php foreach ($opciones as $valor => $texto): ?>
                                        <div class="form-check ps-0">
                                            <input class="form-check-input me-2" type="radio" 
                                                name="pregunta<?= $indice + 1 ?>" 
                                                id="pregunta<?= $indice + 1 ?>_<?= $valor ?>" 
                                                value="<?= $valor ?>" required>
                                            <label class="form-check-label w-100 py-2 ps-2 d-block" 
                                                for="pregunta<?= $indice + 1 ?>_<?= $valor ?>"
                                                style="border-left: 3px solid #dee2e6; border-radius: 4px;">
                                                <?= $texto ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="autorizacion" id="autorizacion" required>
                            <label class="form-check-label" for="autorizacion">
                                Autorizo el uso de esta información
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Enviar Test</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const radios = document.querySelectorAll('input[type="radio"]:checked');
            if (radios.length !== <?= count($preguntas) ?>) {
                e.preventDefault();
                alert('Debes responder todas las preguntas');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>