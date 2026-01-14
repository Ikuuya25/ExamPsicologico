<?php
session_start();
include "../config/config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen EPQ</title>
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
            overflow-y: auto;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .question-card {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
        }

        .question-text {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .radio-options {
            display: flex;
            gap: 20px;
        }

        .form-check-label {
            cursor: pointer;
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
        <div class="form-container">
            <h2 class="mb-4">Cuestionario de Personalidad EPQ</h2>
            
            <div class="alert alert-info mb-4">
                <strong>Instrucciones:</strong> Por favor, lea cada pregunta cuidadosamente y responda marcando "Sí" o "No" según corresponda a su caso personal. Responda con sinceridad, no hay respuestas correctas o incorrectas.
            </div>

            <form id="epq-form" action="proc_epq.php" method="POST">
                <input type="hidden" name="examen_id" value="1">
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre Completo:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" id="edad" name="edad" class="form-control" required min="12" max="99">
                    </div>
                    <div class="col-md-4">
                        <label for="genero" class="form-label">Género:</label>
                        <select id="genero" name="genero" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                </div>

                <h4 class="mb-3">Preguntas:</h4>
                <div id="preguntas-container">
                    <!-- Las preguntas se generarán aquí con JavaScript -->
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="responderAleatoriamente()">Responder Aleatoriamente</button>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Enviar Respuestas</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Lista completa de las 83 preguntas del EPQ
        const preguntasEPQ = [
            "¿Se para a pensar las cosas antes de hacerlas?",
            "¿Su estado de animo sufre altibajos con frecuencia?",
            "¿Es una persona conversadora?",
            "¿Se siente a veces desdichado sin motivo?",
            "¿Alguna vez ha querido llevarse mas de lo que de lo que le correspondía en un reparto?",
            "¿Es usted una persona mas bien animada o vital?",
            "Si usted asegura que hará una cosa, ¿Siempre mantiene su promesa, sin importar las molestas que ello le pueda ocasionar?",
            "¿Es una persona irritable?",
            "¿Le tiene sin cuidado lo que piensen los demás?",
            "¿Alguna vez ha culpado a alguien por algo que había hecho usted?",
            "¿Son todos sus hábitos buenos y deseables?",
            "¿Tiende a mantenerse apartado/a en las situaciones sociales?",
            "A menudo ¿Se siente harto/a?",
            "¿Ha cogido alguna vez alguna cosa (aunque no fuese más que un alfiler o un botón) que perteneciese a otra persona?",
            "Para usted, ¿Los límites entre lo que está bien y lo que está mal son menos claros qué para la mayoría de la gente?",
            "¿Le gusta salir a menudo?",
            "¿Es mejor actuar como uno quiera que seguir las normas sociales?",
            "¿Tiene a menudo sentimientos de culpabilidad?",
            "¿Diría de sí mismo que es una persona nerviosa?",
            "¿Es usted una persona sufrida?",
            "¿Alguna vez ha roto o perdido algo que le perteneciese a otra persona?",
            "¿Generalmente toma la iniciativa al hacer nuevas amistades?",
            "¿Los deseos personales están por encima de las normas sociales?",
            "¿Diría de si mismo que es una persona tensa o muy nerviosa?",
            "Por lo general, ¿Suele estar callado/a cuando esta con otras personas?",
            "¿Usted considera que el matrimonio está obsoleto y debiese eliminarse?",
            "¿Puede animar fácilmente una fiesta aburrida?",
            "¿Le gusta contar chistes e historias divertidas a sus amigos?",
            "¿La mayoría de las cosas le son indiferentes?",
            "¿De niño, fue alguna vez descarado con sus padres?",
            "¿Le gusta mezclarse con gente?",
            "¿Se siente a menudo apático/a y cansado/a sin motivo?",
            "¿Ha hecho alguna vez trampas en el juego?",
            "¿A menudo toma decisiones sin pararse a reflexionar?",
            "¿A menudo siente que la vida es muy monótona?",
            "¿Alguna vez se ha aprovechado de alguien?",
            "¿Cree que la gente pierde el tiempo al proteger su futuro con ahorros y seguros?",
            "¿Evadiría impuestos se estuviera seguro de que nunca seria descubierto?",
            "¿Puede organizar y conducir una fiesta?",
            "¿Generalmente, reflexiona antes de actuar?",
            "¿Sufre de los “Nervios”?",
            "¿A menudo se siente solo?",
            "¿Hace siempre lo que predica?",
            "¿Es mejor seguir las normas de la sociedad que ir a su aire?",
            "¿Alguna vez ha llegado tarde a una cita o trabajo?",
            "¿Le gusta el bullicio y la agitación a su alrededor?",
            "¿La gente piensa que usted es una persona animada?",
            "¿Cree que los planes de seguros son una buena idea?",
            "¿Realiza muchas actividades de tiempo libre?",
            "¿Daria dinero para fines caritativos?",
            "¿Le afectaría mucho ver sufrir a un niño o a un animal?",
            "¿Se preocupa a menudo por las cosas que no debería haber dicho o hecho?",
            "¿Habitualmente, es capaz de liberarse y disfrutar en una fiesta animada?",
            "¿Se siente fácilmente herido en sus sentimientos?",
            "¿Disfruta hiriendo a las personas que ama?",
            "¿Habla a veces de cosas de las que no sabe nada?",
            "¿Prefiere leer a conocer gente?",
            "¿Tiene muchos amigos?",
            "¿Se ha enfrentado constantemente a sus padres?",
            "¿Cuándo era niño, hacia enseguida las cosas que le pedían y sin refunfuñar?",
            "¿Se ha opuesto frecuentemente a los deseos de sus padres?",
            "¿Se inquieta por cosas terribles que podrían suceder?",
            "¿Es usted mas permisivo o perdonador que la mayoría de las personas acerca del bien y el mal?",
            "¿Se siente intranquilo por su salud?",
            "¿Alguna vez ha dicho algo malo o desagradable acerca de otra persona?",
            "¿Le gusta cooperar con los demás?",
            "¿Se preocupa si sabe que hay errores en su trabajo?",
            "¿Se lava siempre las manos antes de comer?",
            "¿Casi siempre tiene una respuesta “a punto” cuando le hablan?",
            "¿Le gusta hacer cosas en las que tienen que actuar rápidamente?",
            "¿Es (o era) su madre una buena mujer?",
            "¿Le preocupa mucho su aspecto?",
            "¿Alguna vez he deseado morirse?",
            "¿Trata de no ser grosero con la gente?",
            "¿Después de una experiencia embarazosa, se siente preocupado durante mucho tiempo?",
            "¿Se siente fácilmente herido cuando la gente encuentra defectos en usted o en su trabajo?",
            "¿Frecuentemente improvisa decisiones en función de la situación?",
            "¿Se siente a veces desbordante de energía y otras veces muy decaído?",
            "¿A veces deja para mañana lo que debería hacer hoy?",
            "¿La gente le cuenta muchas mentiras?",
            "¿Existen cosas que le afecten más fácilmente que otras?",
            "Cuando ha cometido una equivocación, ¿Esta siempre dispuesto a admitirlo?",
            "Cuando tiene mal humor, ¿Le cuesta controlarse?"
        ];

        // Función para generar las preguntas
        function generarPreguntas() {
            const container = document.getElementById("preguntas-container");
            
            preguntasEPQ.forEach((pregunta, index) => {
                const questionNumber = index + 1;
                const questionDiv = document.createElement("div");
                questionDiv.className = "question-card";
                questionDiv.innerHTML = `
                    <div class="question-text">${questionNumber}. ${pregunta}</div>
                    <div class="radio-options">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="p${questionNumber}" id="p${questionNumber}_si" value="1" required>
                            <label class="form-check-label" for="p${questionNumber}_si">Sí</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="p${questionNumber}" id="p${questionNumber}_no" value="0" required>
                            <label class="form-check-label" for="p${questionNumber}_no">No</label>
                        </div>
                    </div>
                `;
                container.appendChild(questionDiv);
            });
        }

        // Generar las preguntas cuando el DOM esté cargado
        document.addEventListener("DOMContentLoaded", generarPreguntas);
    </script>
    <script>
    function responderAleatoriamente() {
    for (let i = 1; i <= preguntasEPQ.length; i++) {
        const respuesta = Math.random() < 0.5 ? 'si' : 'no';
        document.getElementById(`p${i}_${respuesta}`).checked = true;
    }
}
</script>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>