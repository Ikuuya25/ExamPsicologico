<?php
session_start();
include "../config/config.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Pittsburgh - PrevenirSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
    <!-- Barra lateral -->
    <div class="sidebar">
        <ul>
            <li onclick="location.href='index.html'"><i class="fa fa-home"></i> Inicio</li>
            <li><i class="fa fa-tachometer-alt"></i> Panel</li>
            <li onclick="location.href='examenes.html'"><i class="fa fa-edit"></i> Exámenes</li>
            <li><i class="fa fa-table"></i> Información Usuarios</li>
            <li><i class="fa fa-sitemap"></i> Menú</li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="container">
        <h2>Cuestionario Calidad del Sueño de Pittsburgh</h2>
        <p>Complete el cuestionario seleccionando una opción para cada pregunta.</p>
        <div class="form-container">
            <form id="encuestaForm" action="proc_pittsburgh.php" method="POST">
                <!-- Campos de información personal -->
                <label for="nombre">Nombre Completo: <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>

                <label for="rut">Rut (12345678-9): <span class="required">*</span></label>
                <input type="text" id="rut" name="rut" class="form-control" required>

                <label for="email">Correo: <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-control" required>

                <!-- Pregunta 1: Hora de acostarse -->
                <div class="form-group">
                    <label for="pregunta1">1. Durante el último mes, ¿cuál ha sido, normalmente, su hora de acostarse? (Las horas indicadas en la pregunta, son en horario PM). <span class="required">*</span></label>
                    <select class="form-control" name="pregunta1" id="pregunta1" required>
                        <option value="5">Entre las 19 y 20 hrs</option>
                        <option value="6">Entre las 20 y 21 hrs</option>
                        <option value="7">Entre las 21 y 22 hrs</option>
                        <option value="8">Entre las 22 y 23 hrs</option>
                        <option value="9">Entre las 23 y 24 hrs</option>
                        <option value="10">Entre las 0 y 1 Am</option>
                    </select>
                </div>

                <!-- Pregunta 2: Tiempo en dormirse -->
                <div class="form-group">
                    <label>2. ¿Cuánto tiempo habrá tardado en dormirse, normalmente, las noches del último mes? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta2_1" name="pregunta2" value="Menos de 15 min" required>
                            Menos de 15 min
                        </label>
                        <label>
                            <input type="radio" id="pregunta2_2" name="pregunta2" value="Entre 16-30 min">
                            Entre 16-30 min
                        </label>
                        <label>
                            <input type="radio" id="pregunta2_3" name="pregunta2" value="Entre 31-60 min">
                            Entre 31-60 min
                        </label>
                        <label>
                            <input type="radio" id="pregunta2_4" name="pregunta2" value="Más de 60 min">
                            Más de 60 min
                        </label>
                    </div>
                </div>

                <!-- Pregunta 3: Hora de levantarse -->
                <div class="form-group">
                    <label for="pregunta3">3. Durante el último mes, ¿cuál ha sido, normalmente, su hora de levantarse? (Las horas indicadas en la pregunta, son en horario AM). <span class="required">*</span></label>
                    <select class="form-control" name="pregunta3" id="pregunta3" required>
                        <option value="5">5 AM</option>
                        <option value="6">6 AM</option>
                        <option value="7">7 AM</option>
                        <option value="8">8 AM</option>
                        <option value="9">9 AM</option>
                        <option value="10">10 AM</option>
                        <option value="11">11 AM</option>
                    </select>
                </div>

                <!-- Pregunta 4: Horas de sueño -->
                <div class="form-group">
                    <label>4. ¿Cuántas horas calcula que habrá dormido verdaderamente cada noche durante el último mes? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta4_1" name="pregunta4" value="Más de 7 horas" required>
                            Más de 7 horas
                        </label>
                        <label>
                            <input type="radio" id="pregunta4_2" name="pregunta4" value="Entre 6 y 7 horas">
                            Entre 6 y 7 horas
                        </label>
                        <label>
                            <input type="radio" id="pregunta4_3" name="pregunta4" value="Entre 5 y 6 horas">
                            Entre 5 y 6 horas
                        </label>
                        <label>
                            <input type="radio" id="pregunta4_4" name="pregunta4" value="Menos de 5 horas">
                            Menos de 5 horas
                        </label>
                    </div>
                </div>
                <!-- Pregunta 5: Problemas para dormir -->
                <h2>5. Durante el último mes, cuántas veces ha tenido usted problemas para dormir a causa de:</h2>
                <?php
                $preguntas5 = [
                    "5.A - No poder conciliar el sueño en la primera media hora:",
                    "5.B - Despertarse durante la noche o de madrugada:",
                    "5.C - Tener que levantarse para ir al servicio:",
                    "5.D - No poder respirar bien:",
                    "5.E - Toser o roncar ruidosamente:",
                    "5.F - Sentir frio:",
                    "5.G - Sentir demasiado calor:",
                    "5.H - Tener pesadillas o malos sueños:",
                    "5.I - Sufrir dolores:",
                    "5.J - Otras razones:"
                ];

                foreach ($preguntas5 as $index => $pregunta): ?>
                    <div class="form-group">
                        <label for="pregunta5_<?= $index + 1 ?>"><?= $pregunta ?> <span class="required">*</span></label>
                        <select class="form-control" name="pregunta5_<?= $index + 1 ?>" id="pregunta5_<?= $index + 1 ?>" required>
                            <option value="Ninguna vez en el último mes">Ninguna vez en el último mes</option>
                            <option value="Menos de una vez a la semana">Menos de una vez a la semana</option>
                            <option value="Una o dos veces a la semana">Una o dos veces a la semana</option>
                            <option value="Tres o más veces a la semana">Tres o más veces a la semana</option>
                        </select>
                    </div>
                <?php endforeach; ?>

                <!-- Pregunta 6: Calidad del sueño -->
                <div class="form-group">
                    <label>6. Durante el último mes, ¿cómo valoraría en conjunto, la calidad de su sueño? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta6_1" name="pregunta6" value="Muy buena" required>
                            Muy buena
                        </label>
                        <label>
                            <input type="radio" id="pregunta6_2" name="pregunta6" value="Bastante buena">
                            Bastante buena
                        </label>
                        <label>
                            <input type="radio" id="pregunta6_3" name="pregunta6" value="Bastante mala">
                            Bastante mala
                        </label>
                        <label>
                            <input type="radio" id="pregunta6_4" name="pregunta6" value="Muy mala">
                            Muy mala
                        </label>
                    </div>
                </div>

                <!-- Pregunta 7: Medicinas para dormir -->
                <div class="form-group">
                    <label>7. Durante el último mes, ¿cuántas veces habrá tomado medicinas (por su cuenta o recetadas por el médico) para dormir? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta7_1" name="pregunta7" value="Ninguna vez en el último mes" required>
                            Ninguna vez en el último mes
                        </label>
                        <label>
                            <input type="radio" id="pregunta7_2" name="pregunta7" value="Menos de una vez a la semana">
                            Menos de una vez a la semana
                        </label>
                        <label>
                            <input type="radio" id="pregunta7_3" name="pregunta7" value="Una o dos veces a la semana">
                            Una o dos veces a la semana
                        </label>
                        <label>
                            <input type="radio" id="pregunta7_4" name="pregunta7" value="Tres o más veces a la semana">
                            Tres o más veces a la semana
                        </label>
                    </div>
                </div>

                <!-- Pregunta 8: Somnolencia durante actividades -->
                <div class="form-group">
                    <label>8. Durante el último mes, ¿cuántas veces ha sentido somnolencia mientras conducía, comía o desarrollaba alguna otra actividad? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta8_1" name="pregunta8" value="Ninguna vez en el último mes" required>
                            Ninguna vez en el último mes
                        </label>
                        <label>
                            <input type="radio" id="pregunta8_2" name="pregunta8" value="Menos de una vez a la semana">
                            Menos de una vez a la semana
                        </label>
                        <label>
                            <input type="radio" id="pregunta8_3" name="pregunta8" value="Una o dos veces a la semana">
                            Una o dos veces a la semana
                        </label>
                        <label>
                            <input type="radio" id="pregunta8_4" name="pregunta8" value="Tres o más veces a la semana">
                            Tres o más veces a la semana
                        </label>
                    </div>
                </div>

                <!-- Pregunta 9: Problemas para realizar actividades -->
                <div class="form-group">
                    <label>9. Durante el último mes, ¿ha representado para usted mucho problema el tener ánimos para realizar alguna de las actividades detalladas en la pregunta anterior? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta9_1" name="pregunta9" value="Ningún problema" required>
                            Ningún problema
                        </label>
                        <label>
                            <input type="radio" id="pregunta9_2" name="pregunta9" value="Sólo un leve problema">
                            Sólo un leve problema
                        </label>
                        <label>
                            <input type="radio" id="pregunta9_3" name="pregunta9" value="Un problema">
                            Un problema
                        </label>
                        <label>
                            <input type="radio" id="pregunta9_4" name="pregunta9" value="Un grave problema">
                            Un grave problema
                        </label>
                    </div>
                </div>

                <!-- Pregunta 10: Dormir solo o acompañado -->
                <div class="form-group">
                    <label>10. ¿Duerme usted solo o acompañado? <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" id="pregunta10_1" name="pregunta10" value="Solo" required>
                            Solo
                        </label>
                        <label>
                            <input type="radio" id="pregunta10_2" name="pregunta10" value="Con alguien en otra habitación">
                            Con alguien en otra habitación
                        </label>
                        <label>
                            <input type="radio" id="pregunta10_3" name="pregunta10" value="En la misma habitación, pero en otra cama">
                            En la misma habitación, pero en otra cama
                        </label>
                        <label>
                            <input type="radio" id="pregunta10_4" name="pregunta10" value="En la misma cama">
                            En la misma cama
                        </label>
                    </div>
                </div>
                <!-- Autorización -->
                <div class="form-group">
                    <label>Al enviar, conforme a lo dispuesto en la Ley 19.628, autorizo a PrevenirSalud para la utilización de los resultados de esta evaluación con el fin de generar informe y enviarlo a la empresa solicitante. <span class="required">*</span></label>
                    <div>
                        <input type="checkbox" id="autorizacion" name="autorizacion" required>
                        <label for="autorizacion">Acepto</label>
                    </div>
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
            </form>
        </div>
    </div>
</body>
</html>