
<?php
session_start();
include "../config/config.php";

// 1. Definir el array de preguntas y respuestas correctas
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
        "serie" => "6  9  12  ___  18  21  ___  24  ___  30",
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

// 2. Definir respuestas correctas (puedes tener esto en otro archivo)
$respuestas_correctas = [
    "p1" => "c",
    "p2" => "b",
    "p3" => "d",
    "p4" => "e",
    "p5" => "30 y 50",
    "p6" => "c",
    "p7" => "d",
    "p8" => "b",
    "p9" => "a",
    "p10" => "15 y 24",
    "p11" => "d",
    "p12" => "e",
    "p13" => "c",
    "p14" => "b",
    "p15" => "15 y 19",
    "p16" => "b",
    "p17" => "a",
    "p18" => "c",
    "p19" => "d",
    "p20" => "35 y 56",
    "p21" => "c",
    "p22" => "d",
    "p23" => "b",
    "p24" => "a",
    "p25" => "24 y 8",
    "p26" => "c",
    "p27" => "b",
    "p28" => "d",
    "p29" => "e",
    "p30" => "15 y 24",
    "p31" => "c",
    "p32" => "a",
    "p33" => "b",
    "p34" => "c",
    "p35" => "32 y 128",
    "p36" => "d",
    "p37" => "b",
    "p38" => "c",
    "p39" => "25 y 49",
    "p40" => "d",
    "p41" => "20 y 30",
    "p42" => "c",
    "p43" => "d",
    "p44" => "70 y 50",
    "p45" => "b",
    "p46" => "d",
    "p47" => "54 y 36",
    "p48" => "d",
    "p49" => "c",
    "p50" => "16 y 64",
    "p51" => "b",
    "p52" => "a",
    "p53" => "17 y 21",
    "p54" => "d",
    "p55" => "c",
    "p56" => "40 y 0",
    "p57" => "c",
    "p58" => "d",
    "p59" => "30 y 50",
    "p60" => "b"
];


// 3. Fusionar las respuestas correctas al array de preguntas
foreach ($preguntas as &$pregunta) {
    $name = $pregunta['name'];
    if (isset($respuestas_correctas[$name])) {
        $pregunta['respuesta_correcta'] = $respuestas_correctas[$name];
    }
}
unset($pregunta); // Romper la referencia

// 4. Función para procesar el examen
function procesarExamenBarsit($usuario_id, $examen_id, $preguntas) {
    global $conn;
    
    $conn->autocommit(false);
    
    try {
        $puntaje_total = 0;
        $respondidas = 0;
        $total_preguntas = count($preguntas);
        
        foreach ($preguntas as $pregunta) {
            $nombreCampo = $pregunta['name'];
            
            if (!isset($_POST[$nombreCampo]) || empty($_POST[$nombreCampo])) {
                continue; // Saltar si no hay respuesta
            }
            
            $respuesta_usuario = strtolower(trim($_POST[$nombreCampo]));
            $respondidas++;
            
            // Validar formato de respuesta
            if (!preg_match("/{$pregunta['pattern']}/", $respuesta_usuario)) {
                throw new Exception("Formato de respuesta inválido para pregunta {$pregunta['numero']}");
            }
            
            // Comparar con respuesta correcta
            if ($respuesta_usuario === strtolower($pregunta['respuesta_correcta'])) {
                $puntaje_total++;
            }
        }
        
        // Validar que haya respondido al menos una pregunta
        if ($respondidas === 0) {
            throw new Exception("No se respondió ninguna pregunta");
        }
        
        // Guardar en respuestas
        $stmt = $conn->prepare("INSERT INTO respuestas 
                              (usuario_id, examen_id, respuesta, respondidas, total_preguntas, fecha) 
                              VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiiii", $usuario_id, $examen_id, $puntaje_total, $respondidas, $total_preguntas);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar resultados: " . $stmt->error);
        }
        
        // Guardar en resultados
        $nombre = $_SESSION['nombre'] ?? 'Anónimo'; 
        $edad = (int)$_POST['edad'];
        $genero = in_array($_POST['genero'], ['Masculino', 'Femenino']) ? $_POST['genero'] : 'Otro';
        
        $stmt_result = $conn->prepare("INSERT INTO resultados 
                                     (usuario_id, examen_id, nombre_paciente, edad, genero, fecha) 
                                     VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt_result->bind_param("iisis", $usuario_id, $examen_id, $nombre, $edad, $genero);
        
        if (!$stmt_result->execute()) {
            throw new Exception("Error al guardar resultados complementarios: " . $stmt_result->error);
        }
        
        // Actualizar estado del examen
        $update = $conn->prepare("UPDATE usuario_examen 
                                 SET completado = 1, activo = 0 
                                 WHERE usuario_id = ? AND examen_id = ?");
        $update->bind_param("ii", $usuario_id, $examen_id);
        
        if (!$update->execute()) {
            throw new Exception("Error actualizando estado: " . $update->error);
        }
        
        $conn->commit();
        return [
            'puntaje' => $puntaje_total,
            'respondidas' => $respondidas,
            'total_preguntas' => $total_preguntas
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}
try {
    // [Tus validaciones iniciales...]
    
    // Procesar el examen
    procesarExamenBarsit($_SESSION['id'], $_POST['examen_id'], $preguntas);
    
    header("Location: ../examenes.php?success=1");
    exit();
    
} catch (Exception $e) {
    header("Location: ../examenes.php?error=" . urlencode($e->getMessage()));
    exit();
}