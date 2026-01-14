<?php
session_start();
include "../config/config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->autocommit(false);

try {
    // 1. Verificar sesión
    if (empty($_SESSION['id'])) {
        throw new Exception("Debe iniciar sesión primero");
    }

    // 2. Validar campos obligatorios
    $required = ['nombre', 'edad', 'genero', 'examen_id'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Falta el campo requerido: $field");
        }
    }

    // 3. Sanitizar y validar datos
    $examen_id = (int)$_POST['examen_id'];
    $usuario_id = (int)$_SESSION['id'];
    
    if ($examen_id <= 0) {
        throw new Exception("ID de examen no válido");
    }

    // 4. Verificar que el examen está asignado al usuario
    $stmt = $conn->prepare("SELECT 1 FROM usuario_examen 
                           WHERE usuario_id = ? 
                           AND examen_id = ? 
                           AND activo = 1");
    $stmt->bind_param("ii", $usuario_id, $examen_id);
    $stmt->execute();

$respuestas = [
    'calidad_subjetiva' => ??,   // 0 a 3
    'latencia_sueño' => ??,      // 0 a 3
    'duracion_sueño' => ??,      // 0 a 3
    'eficiencia_sueño' => ??,    // 0 a 3
    'perturbaciones' => ??,      // 0 a 3
    'medicacion' => ??,          // 0 a 3
    'disfuncion_dia' => ??       // 0 a 3
];

function evaluarPSQI($respuestas) {
    $componentes = [
        'Calidad subjetiva del sueño' => $respuestas['calidad_subjetiva'],
        'Latencia del sueño' => $respuestas['latencia_sueño'],
        'Duración del sueño' => $respuestas['duracion_sueño'],
        'Eficiencia habitual del sueño' => $respuestas['eficiencia_sueño'],
        'Perturbaciones del sueño' => $respuestas['perturbaciones'],
        'Uso de medicación para dormir' => $respuestas['medicacion'],
        'Disfunción durante el día' => $respuestas['disfuncion_dia']
    ];

    $puntaje_total = array_sum($componentes);

    // Interpretación según puntaje total
    if ($puntaje_total <= 5) {
        $estado = "Buena calidad de sueño";
    } elseif ($puntaje_total <= 10) {
        $estado = "Calidad de sueño algo mala";
    } else {
        $estado = "Mala calidad de sueño";
    }

    return [
        'componentes' => $componentes,
        'puntaje_total' => $puntaje_total,
        'estado' => $estado
    ];
}
