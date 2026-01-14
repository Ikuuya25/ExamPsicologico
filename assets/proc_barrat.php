<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuestas = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'pregunta') === 0) { // Verifica si la clave comienza con "pregunta"
            $respuestas[$key] = $value;
        }
    }

    // Mostrar las respuestas (puedes guardarlas en una base de datos o enviarlas por correo)
    echo "<h1>Respuestas:</h1>";
    foreach ($respuestas as $pregunta => $respuesta) {
        echo "<p><strong>$pregunta:</strong> $respuesta</p>";
    }
}
?>