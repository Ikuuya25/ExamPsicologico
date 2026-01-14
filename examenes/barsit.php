<?php
session_start();
include "../config/config.php";
$examen_id = 7;
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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .form-container h2 {
            color: #1a3d7c;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .question-container {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .question-container:last-child {
            border-bottom: none;
        }

        .question-text {
            font-weight: bold;
            color: #1a3d7c;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .options-container {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 15px;
        }

        .option-item {
            margin-bottom: 5px;
        }

        .answer-input {
            width: 200px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }

        .answer-input.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .authorization {
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .btn-submit {
            background-color: #0056a3;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: block;
            margin: 30px auto 0;
        }

        .btn-submit:hover {
            background-color: #003d75;
        }

        .required {
            color: red;
            margin-left: 5px;
        }

        .instructions {
            background-color: #e9f5ff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #0056a3;
        }

        .timer {
            background-color: #1a3d7c;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .format-hint {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
            }
            .answer-input {
                width: 100%;
            }
        }
        .series-style {
            font-family: monospace;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Barra lateral -->
    <div class="sidebar">
        <ul>
            <li onclick="location.href='../examenes.php'"><i class="fa fa-edit"></i> Exámenes</li>
            <li onclick="location.href='../config/logout.php'"><i class="fa fa-bars"></i> Cerrar sesión</li>
        </ul>
    </div>

    
    <!-- Contenido principal -->
    <div class="content">
        <div class="form-container">
            <h2>Test de Inteligencia BARSIT</h2>
            
            <div class="instructions">
                <h4>Instrucciones:</h4>
                <p>Este test consta de 60 preguntas divididas en 5 secciones. Dispone de 10 minutos para completarlo.</p>
                <p>Escriba su respuesta en el espacio provisto para cada pregunta.</p>
                <div class="timer">Tiempo restante: <span id="time">10:00</span></div>
            </div>
            
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
                                <div class="col-md-4">
                                    <label for="genero" class="form-label">Género:</label>
                                    <select id="genero" name="genero" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                                <input type="hidden" name="examen_id" value="<?= isset($_GET['examen_id']) ? htmlspecialchars($_GET['examen_id']) : '' ?>">
                            </div>
                        </div>
            <form id="barsitForm" action="proc_barsit.php" method="POST">
                <?php
                $preguntas = [
                    [
                        "numero" => 1,
                        "tipo" => 1,
                        "texto" => "El queso se fabrica de:",
                        "opciones" => ["a) Las Flores", "b) La harina", "c) La leche", "d) Las uvas", "e) El azúcar"],
                        "name" => "p1",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 2,
                        "tipo" => 1,
                        "texto" => "Lo contrario de abierto es:",
                        "opciones" => ["a) Liso", "b) Cerrado", "c) Delante", "d) Claro", "e) Despejado"],
                        "name" => "p2",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 3,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente. ¿Cuál es?",
                        "opciones" => ["a) Rojo", "b) Amarillo", "c) Morado", "d) Bandera", "e) Verde"],
                        "name" => "p3",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 4,
                        "tipo" => 1,
                        "texto" => "El pájaro canta y el perro:",
                        "opciones" => ["a) Habla", "b) Rebuzna", "c) Cacarea", "d) Maúlla", "e) Ladra"],
                        "name" => "p4",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 5,
                        "tipo" => 2,
                        "texto" => "Escriba los dos números que faltan en esta serie:",
                        "serie" => "10  15  20  25  ___    35  40   45  ___  55",
                        "name" => "p5",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 6,
                        "tipo" => 1,
                        "texto" => "Para medir la temperatura se emplea el.",
                        "opciones" => ["a) Litro", "b) Gramo", "c) Termómetro", "d) Metro", "e) Kilovatio"],
                        "name" => "p6",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 7,
                        "tipo" => 1,
                        "texto" => "Lo contrario de dormido es.",
                        "opciones" => ["a) Noche", "b) Luz", "c) Amanecer", "d) Despierto", "e) Claridad"],
                        "name" => "p7",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 8,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente. ¿Cuál es?",
                        "opciones" => ["a) Agua", "b) Platino", "c) Café", "d) Té", "e) Cerveza"],
                        "name" => "p8",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 9,
                        "tipo" => 1,
                        "texto" => "El zapato protege al pie y el sombrero protege a:",
                        "opciones" => ["a) La cabeza", "b) la mano", "c) el dedo", "d) el brazo", "e) la rodilla"],
                        "name" => "p9",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 10,
                        "tipo" => 2,
                        "texto" => "Escriba los dos números que faltan en esta serie:",
                        "serie" => "6  9  12  ___  18  21  ___  30",
                        "name" => "p10",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 11,
                        "tipo" => 1,
                        "texto" => "El triángulo es una figura formada por:",
                        "opciones" => ["a) 4 lados", "b) 6 lados", "c) 5 lados", "d) 3 lados", "e) 9 lados"],
                        "name" => "p11",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 12,
                        "tipo" => 1,
                        "texto" => "Lo contrario de negro es:",
                        "opciones" => ["a) oscuro", "b) sombra", "c) opaco", "d) sucio", "e) blanco"],
                        "name" => "p12",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 13,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente ¿Cuál es?",
                        "opciones" => ["a) Pedro", "b) Enrique", "c) Ana", "d) José", "e) Carlos"],
                        "name" => "p13",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 14,
                        "tipo" => 1,
                        "texto" => "El naranjo es un árbol y el perro es:",
                        "opciones" => ["a) un objeto", "b) un animal", "c) una cosa", "d) un mineral", "e) un vegetal"],
                        "name" => "p14",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 15,
                        "tipo" => 2,
                        "texto" => "Escriba los números que faltan en esta serie:",
                        "serie" => "7  9  11  13  ___  17  ___  21  23",
                        "name" => "p15",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 16,
                        "tipo" => 1,
                        "texto" => "El gato es un:",
                        "opciones" => ["a) insecto", "b) mamífero", "c) ave", "d) pez", "e) reptil"],
                        "name" => "p16",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 17,
                        "tipo" => 1,
                        "texto" => "Lo contrario de triste es:",
                        "opciones" => ["a) alegre", "b) preocupado", "c) dolorido", "d) desgraciado", "e) enfermo"],
                        "name" => "p17",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 18,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente ¿Cuál es?",
                        "opciones" => ["a) Bogotá", "b) Lima", "c) Alpes", "d) Caracas", "e) Quito"],
                        "name" => "p18",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 19,
                        "tipo" => 1,
                        "texto" => "La piel cubre al hombre y las plumas cubren a:",
                        "opciones" => ["a) la vaca", "b) el perro", "c) el gato", "d) la gallina", "e) el caballo"],
                        "name" => "p19",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 20,
                        "tipo" => 2,
                        "texto" => "Escriba los dos números que faltan en esta serie:",
                        "serie" => "7  14  21  28  ___  42  ___  49  ___  63  70",
                        "name" => "p20",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 21,
                        "tipo" => 1,
                        "texto" => "Treinta es el triple de:",
                        "opciones" => ["a) quince", "b) tres", "c) diez", "d) doce", "e) cinco"],
                        "name" => "p21",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 22,
                        "tipo" => 1,
                        "texto" => "Lo contrario de calor es:",
                        "opciones" => ["a) sudor", "b) fatiga", "c) blanco", "d) frío", "e) luz"],
                        "name" => "p22",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 23,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente ¿Cuál es?",
                        "opciones" => ["a) cuchara", "b) plato", "c) tenedor", "d) cuchillo", "e) cucharita"],
                        "name" => "p23",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 24,
                        "tipo" => 1,
                        "texto" => "Para coser se emplea la aguja y para dibujar se emplea él.",
                        "opciones" => ["a) lápiz", "b) bastón", "c) tintero", "d) pie", "e) el ojo"],
                        "name" => "p24",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 25,
                        "tipo" => 2,
                        "texto" => "Escriba los dos números que faltan en esta serie:",
                        "serie" => "40  36  32  28  ___  20  16  12  ___  4",
                        "name" => "p25",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 26,
                        "tipo" => 1,
                        "texto" => "La Cordillera de los Andes está en:",
                        "opciones" => ["a) Europa", "b) Asia", "c) América", "d) Australia", "e) África"],
                        "name" => "p26",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 27,
                        "tipo" => 1,
                        "texto" => "Lo contrario de arriba es:",
                        "opciones" => ["a) dentro", "b) abajo", "c) cerca", "d) completo", "e) lejos"],
                        "name" => "p27",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 28,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente ¿Cuál es?",
                        "opciones" => ["a) General", "b) Teniente", "c) Capitán", "d) Presidente", "e) Coronel"],
                        "name" => "p28",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 29,
                        "tipo" => 1,
                        "texto" => "Con el cuero se fabrica el calzado y con la tela:",
                        "opciones" => ["a) piel", "b) lana", "c) algodón", "d) seda", "e) vestidos"],
                        "name" => "p29",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 30,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan en la serie:",
                        "serie" => "3  6  9  12  ___  18  21  ___  27",
                        "name" => "p30",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 31,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Enero", "b) Febrero", "c) Lunes", "d) Marzo"],
                        "name" => "p31",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 32,
                        "tipo" => 1,
                        "texto" => "El hierro es a metal como el pino es a:",
                        "opciones" => ["a) Árbol", "b) Flor", "c) Fruta", "d) Madera"],
                        "name" => "p32",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 33,
                        "tipo" => 1,
                        "texto" => "Lo contrario de alegre es:",
                        "opciones" => ["a) Contento", "b) Triste", "c) Enojado", "d) Rápido"],
                        "name" => "p33",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 34,
                        "tipo" => 1,
                        "texto" => "¿Cuál es el resultado de 15 × 4?",
                        "opciones" => ["a) 45", "b) 50", "c) 60", "d) 55"],
                        "name" => "p34",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 35,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "2  4  8  16  ___  64  ___  256",
                        "name" => "p35",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 36,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Ojo", "b) Nariz", "c) Boca", "d) Zapato"],
                        "name" => "p36",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 37,
                        "tipo" => 1,
                        "texto" => "El médico trabaja en un hospital, el profesor trabaja en:",
                        "opciones" => ["a) Oficina", "b) Escuela", "c) Tienda", "d) Fábrica"],
                        "name" => "p37",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 38,
                        "tipo" => 1,
                        "texto" => "¿Cuál es el animal doméstico?",
                        "opciones" => ["a) León", "b) Tigre", "c) Perro", "d) Elefante"],
                        "name" => "p38",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 39,
                        "tipo" => 2,
                        "texto" => "Complete la serie numérica:",
                        "serie" => "1  4  9  16  ___  36  ___  64",
                        "name" => "p39",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 40,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Sol", "b) Luna", "c) Estrella", "d) Avión"],
                        "name" => "p40",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 41,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan en la serie:",
                        "serie" => "5  10  15  ___  25  ___  35",
                        "name" => "p41",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 42,
                        "tipo" => 1,
                        "texto" => "¿Qué se necesita para ver?",
                        "opciones" => ["a) Oídos", "b) Manos", "c) Ojos", "d) Nariz"],
                        "name" => "p42",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 43,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Pan", "b) Leche", "c) Jugo", "d) Zapato"],
                        "name" => "p43",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 44,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan en la serie:",
                        "serie" => "100  90  80  ___  60  ___  40",
                        "name" => "p44",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 45,
                        "tipo" => 1,
                        "texto" => "¿Qué instrumento sirve para cortar?",
                        "opciones" => ["a) Lápiz", "b) Tijera", "c) Regla", "d) Borrador"],
                        "name" => "p45",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 46,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Camión", "b) Auto", "c) Tren", "d) Vaca"],
                        "name" => "p46",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 47,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "81  72  63  ___  45  ___  27",
                        "name" => "p47",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 48,
                        "tipo" => 1,
                        "texto" => "El pez vive en:",
                        "opciones" => ["a) La tierra", "b) El fuego", "c) El aire", "d) El agua"],
                        "name" => "p48",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 49,
                        "tipo" => 1,
                        "texto" => "¿Qué se usa para escribir en una pizarra?",
                        "opciones" => ["a) Lápiz", "b) Goma", "c) Tiza", "d) Pluma"],
                        "name" => "p49",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 50,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "1  2  4  8  ___  32  ___",
                        "name" => "p50",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 51,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Martillo", "b) Clavo", "c) Destornillador", "d) Tornillo"],
                        "name" => "p51",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 52,
                        "tipo" => 1,
                        "texto" => "El sol nos da:",
                        "opciones" => ["a) Luz", "b) Frío", "c) Lluvia", "d) Sombra"],
                        "name" => "p52",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 53,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "11  13  15  ___  19  ___  23",
                        "name" => "p53",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 54,
                        "tipo" => 1,
                        "texto" => "¿Cuál palabra no pertenece al grupo?",
                        "opciones" => ["a) Silla", "b) Mesa", "c) Sofá", "d) Lámpara"],
                        "name" => "p54",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 55,
                        "tipo" => 1,
                        "texto" => "El libro se usa para:",
                        "opciones" => ["a) Comer", "b) Dormir", "c) Leer", "d) Jugar"],
                        "name" => "p55",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 56,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "100  80  60  ___  20  ___",
                        "name" => "p56",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 57,
                        "tipo" => 1,
                        "texto" => "¿Qué se usa para volar?",
                        "opciones" => ["a) Auto", "b) Barco", "c) Avión", "d) Bicicleta"],
                        "name" => "p57",
                        "pattern" => "^[a-dA-D]$"
                    ],
                    [
                        "numero" => 58,
                        "tipo" => 1,
                        "texto" => "De estas cinco palabras una pertenece a una clase diferente ¿Cuál es?",
                        "opciones" => ["a) Strawinski", "b) Bach", "c) Mozart", "d) Newton", "e) Chopin"],
                        "name" => "p58",
                        "pattern" => "^[a-eA-E]$"
                    ],
                    [
                        "numero" => 59,
                        "tipo" => 2,
                        "texto" => "Complete los números que faltan:",
                        "serie" => "10  15  20  25  ___    35  40   45  ___  55",
                        "name" => "p59",
                        "pattern" => "^\\d+\\s+y\\s+\\d+$"
                    ],
                    [
                        "numero" => 60,
                        "tipo" => 1,
                        "texto" => "Si 3 manzanas cuestan $1500, ¿cuánto cuestan 5 manzanas?",
                        "opciones" => ["a) $2000", "b) $2500", "c) $3000", "d) $3500"],
                        "name" => "p60",
                        "pattern" => "^[a-dA-D]$"
                    ]
                ];

                foreach ($preguntas as $pregunta) {
                    echo '<div class="question-container">';
                    echo '<div class="question-text">' . $pregunta['numero'] . '. ' . $pregunta['texto'] . '</div>';
                    
                    if ($pregunta['tipo'] == 1) {
                        // Pregunta tipo opción múltiple
                        echo '<div class="options-container">';
                        foreach ($pregunta['opciones'] as $opcion) {
                            echo '<div class="option-item">' . $opcion . '</div>';
                        }
                        echo '</div>';
                        $placeholder = "Ejemplo: " . strtolower(substr($pregunta['opciones'][0], 0, 1));
                        echo '<input type="text" name="' . $pregunta['name'] . '" class="answer-input" placeholder="' . $placeholder . '" pattern="' . $pregunta['pattern'] . '" required>';
                        echo '<div class="format-hint">Escriba solo la letra de la opción correcta</div>';
                    } else {
                        // Pregunta tipo serie numérica
                        echo '<div class="options-container" style="font-family: monospace; font-size: 18px;">';
                        echo $pregunta['serie'];
                        echo '</div>';
                        echo '<input type="text" name="' . $pregunta['name'] . '" class="answer-input" placeholder="Ejemplo: 30 y 50" pattern="' . $pregunta['pattern'] . '" required>';
                        echo '<div class="format-hint">Formato requerido: número + " y " + número (Ej: 30 y 50)</div>';
                    }
                    
                    echo '</div>';
                }
                ?>
                
                <div class="authorization">
                    <p>Al enviar, conforme a lo dispuesto en la Ley 19.628, autorizo a PrevenirSalud para la utilización de los resultados de esta evaluación con el fin de generar informe y enviarlo a la empresa solicitante.</p>
                    <label>
                        <input type="checkbox" name="autorizacion" required> Acepto
                    </label>
                </div>

                <button type="submit" class="btn-submit">Enviar Test</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Variables para el temporizador
    let timeLeft = 600; // 10 minutos en segundos
    let timerInterval;
    let timerStarted = false;

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('time').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('¡Tiempo terminado! El test se enviará automáticamente.');
            document.getElementById('barsit-form').submit();
        } else {
            timeLeft--;
        }
    }

    // Iniciar el temporizador cuando se hace clic en cualquier campo de respuesta
    document.addEventListener("DOMContentLoaded", function() {
        const answerInputs = document.querySelectorAll(".answer-input");
        
        answerInputs.forEach(input => {
            input.addEventListener("click", function() {
                if (!timerStarted) {
                    timerStarted = true;
                    timerInterval = setInterval(updateTimer, 1000);
                }
            });
        });
    });
</script>
<script>
// Función para autocompletar respuestas
function autocompleteAnswers() {
    // Respuestas para preguntas de opción múltiple (a-e)
    const multipleChoiceAnswers = ['c', 'b', 'd', 'e', 'c', 'd', 'b', 'a', 'd', 'a'];
    
    // Respuestas para series numéricas (formato: "X y Y")
    const seriesAnswers = [
        '30 y 50', 
        '15 y 24', 
        '15 y 19', 
        '35 y 56', 
        '24 y 20', 
        '15 y 24', 
        '32 y 128', 
        '54 y 36', 
        '70 y 50', 
        '16 y 128'
    ];
    
    // Combinar todas las respuestas en orden
    const allAnswers = [];
    for (let i = 0; i < 60; i++) {
        if (i < 50) {
            // Para las primeras 50 preguntas, alternar entre opción múltiple y series
            if (i % 2 === 0) {
                allAnswers.push(multipleChoiceAnswers[i % multipleChoiceAnswers.length]);
            } else {
                allAnswers.push(seriesAnswers[i % seriesAnswers.length]);
            }
        } else {
            // Últimas 10 preguntas (simplificado)
            allAnswers.push(multipleChoiceAnswers[i % multipleChoiceAnswers.length]);
        }
    }
    
    // Autocompletar los campos
    const inputs = document.querySelectorAll('input[class="answer-input"]');
    inputs.forEach((input, index) => {
        if (index < allAnswers.length) {
            input.value = allAnswers[index];
        }
    });
    
    console.log('Respuestas autocompletadas!');
}

// Ejecutar al cargar la página (opcional)
// document.addEventListener('DOMContentLoaded', autocompleteAnswers);

// O crear un botón para activarlo manualmente
const autocompleteBtn = document.createElement('button');
autocompleteBtn.textContent = 'Autocompletar respuestas';
autocompleteBtn.style.position = 'fixed';
autocompleteBtn.style.bottom = '20px';
autocompleteBtn.style.right = '20px';
autocompleteBtn.style.zIndex = '9999';
autocompleteBtn.style.padding = '10px 15px';
autocompleteBtn.style.backgroundColor = '#28a745';
autocompleteBtn.style.color = 'white';
autocompleteBtn.style.border = 'none';
autocompleteBtn.style.borderRadius = '5px';
autocompleteBtn.style.cursor = 'pointer';

autocompleteBtn.addEventListener('click', autocompleteAnswers);
document.body.appendChild(autocompleteBtn);
</script>
</body>
</html>