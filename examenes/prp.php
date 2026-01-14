<?php
session_start();
include "../config/config.php";

// Verificar sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// ID del examen PRP (debería coincidir con tu base de datos)
define('EXAMEN_PRP_ID', 4);

// Preguntas con respuestas invertidas (rojas) - van de 5 a 1
$respuestasRojas = ["P3", "P4", "P5", "P6", "P7", "P9", "P10", "P12", "P13", "P16", "P17", "P20", "P22", "P27", "P28", "P30"];

// Preguntas con respuestas normales (amarillas) - van de 1 a 5
$respuestasAmarillas = ["P1", "P2", "P8", "P11", "P14", "P15", "P18", "P19", "P21", "P23", "P24", "P25", "P26", "P29"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen PRP - PrevenirSalud</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <ul>
        <li onclick="location.href='../examenes.php'"><i class="fa fa-edit"></i> Exámenes</li>
        <li onclick="location.href='../config/logout.php'"><i class="fa fa-bars"></i> Cerrar sesión</li>
    </ul>
</div>

<div class="content">
    <div class="form-container">
        <?php
        $preguntas = [
            "P1" => "Asistiría a un curso de prevención de accidentes de trabajos:",
            "P2" => "Colaboraría en las acciones de prevención de accidentes de trabajo:",
            "P3" => "Asistir a cursos de seguridad es perder el tiempo:",
            "P4" => "La mayoría de los accidentes de trabajo se deben a la mala suerte:",
            "P5" => "Las reuniones mensuales de seguridad solo sirven para perder el tiempo:",
            "P6" => "Por mucho ruido que haya siempre se acostumbra uno:",
            "P7" => "Cada uno tiene su destino y si se ha de accidentar, por más seguro que trabaje, se accidenta:",
            "P8" => "Cada trabajador debe pedir su ropa de seguridad cuando le corresponde:",
            "P9" => "No vale la pena usar protecciones porque el trabajo cunde poco:",
            "P10" => "Aunque una herramienta esté defectuosa con cuidado puede utilizarse:",
            "P11" => "Colaboraría en la confección de carteles de seguridad:",
            "P12" => "Para prevenir de los accidentes no es necesario utilizar los elementos de protección personal:",
            "P13" => "Los accidentes de trabajo solo les ocurren a los demás:",
            "P14" => "El trabajador descuidado pone en peligro a todos sus compañeros:",
            "P15" => "Deberían organizarse más campañas de seguridad:",
            "P16" => "Cuando trabajamos no es posible tener en cuenta todas las normas de seguridad:",
            "P17" => "No uso los lentes de seguridad porque me hacen trabajar incomodo:",
            "P18" => "Se tendría que vigilar más la seguridad en el trabajo:",
            "P19" => "Tendría que haber más supervisión en seguridad:",
            "P20" => "Las normas de seguridad no son problema mío:",
            "P21" => "Aunque sea más lento, prefiero trabajar seguro:",
            "P22" => "La culpa de los accidentes la tienen las maquinas:",
            "P23" => "El experto de prevención es una persona muy necesaria en toda empresa:",
            "P24" => "Me uniría a los que luchan para evitar los accidentes de trabajo:",
            "P25" => "El accidente no avisa, hay que estar alerta:",
            "P26" => "Si debiese hacerlo, usaría todas las protecciones necesarias:",
            "P27" => "La seguridad en el trabajo es cuestión de suerte:",
            "P28" => "A veces uno debe arriesgarse para terminar el trabajo más rápido:",
            "P29" => "Es imprescindible la buena colaboración de todos para una buena seguridad:",
            "P30" => "Muchos jefes molestan a la gente hablando de seguridad de trabajo:",
        ];
        ?>

        <h2>Examen PRP</h2>
        <p>Complete el cuestionario seleccionando una opción para cada pregunta.</p>

        <form method="POST" action="proc_prp.php">
            <!-- Datos básicos del paciente -->
            <div class="form-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" class="form-control" min="1" max="120" required>
            </div>

            <div class="form-group">
                <label for="genero">Género:</label>
                <select id="genero" name="genero" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            <!-- Campo oculto con el ID del examen -->
            <input type="hidden" name="examen_id" value="<?php echo EXAMEN_PRP_ID; ?>">

            <h3 class="mt-4">Cuestionario</h3>
            <div id="preguntas-container">
                <?php foreach ($preguntas as $codigo => $pregunta): 
                    $esPreguntaRoja = in_array($codigo, $respuestasRojas);
                ?>
                    <div class="form-group">
                        <p><strong><?php echo $codigo; ?>:</strong> <?php echo $pregunta; ?></p>
                        <div class="radio-group">
                            <?php 
                            // Opciones para preguntas normales (1-5)
                            $opcionesNormales = [
                                1 => "Totalmente en desacuerdo",
                                2 => "En desacuerdo",
                                3 => "Indeciso",
                                4 => "De acuerdo",
                                5 => "Totalmente de acuerdo"
                            ];
                            
                            // Opciones para preguntas invertidas (5-1)
                            $opcionesInvertidas = [
                                5 => "Totalmente en desacuerdo",
                                4 => "En desacuerdo",
                                3 => "Indeciso",
                                2 => "De acuerdo",
                                1 => "Totalmente de acuerdo"
                            ];
                            
                            $opciones = $esPreguntaRoja ? $opcionesInvertidas : $opcionesNormales;
                            
                            foreach ($opciones as $valor => $texto): ?>
                                <label>
                                    <input type="radio" name="<?php echo $codigo; ?>" 
                                           value="<?php echo $valor; ?>" required>
                                    <?php echo $texto; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Enviar Test</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const preguntas = [
            "P1","P2","P3","P4","P5","P6","P7","P8","P9","P10",
            "P11","P12","P13","P14","P15","P16","P17","P18","P19","P20",
            "P21","P22","P23","P24","P25","P26","P27","P28","P29","P30"
        ];

        preguntas.forEach(p => {
            const opciones = document.querySelectorAll(`input[name="${p}"]`);
            const indiceAleatorio = Math.floor(Math.random() * opciones.length);
            if (opciones[indiceAleatorio]) {
                opciones[indiceAleatorio].checked = true;
            }
        });
    });
</script>
</body>
</html>