<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'config/config.php';

$examen_id = isset($_GET['examen_id']) ? (int)$_GET['examen_id'] : 0;
$fecha_busqueda = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$ot_busqueda = isset($_GET['ot']) ? $_GET['ot'] : '';

$query_pacientes = "
    SELECT 
        r.usuario_id,
        r.examen_id,
        r.respuesta as total,
        r.puntaje_cognitivo,
        r.puntaje_motor,
        r.puntaje_no_planeado,
        r.respondidas,
        r.total_preguntas,
        res.nombre_paciente, 
        res.edad, 
        res.genero, 
        r.fecha,
        u.ot,
        r.neuroticismo,
        r.psicoticismo
    FROM respuestas r
    LEFT JOIN resultados res ON r.usuario_id = res.usuario_id AND r.examen_id = res.examen_id
    JOIN usuarios u ON r.usuario_id = u.id
    WHERE r.examen_id = ? 
    AND DATE(r.fecha) = ? 
    " . ($ot_busqueda ? " AND u.ot LIKE ? " : "") . "
    ORDER BY r.fecha DESC
";

$stmt = $conn->prepare($query_pacientes);
if ($stmt === false) {
    die("Error en la consulta SQL: " . $conn->error);
}

if ($ot_busqueda) {
    $ot_param = "%" . $ot_busqueda . "%";
    $stmt->bind_param("iss", $examen_id, $fecha_busqueda, $ot_param);
} else {
    $stmt->bind_param("is", $examen_id, $fecha_busqueda);
}

if (!$stmt->execute()) {
    die("Error al ejecutar: " . $stmt->error);
}

$result = $stmt->get_result();
$pacientes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

function obtenerCategoriaHamilton($total) {
    if ($total > 24) {
        return '<span class="badge bg-danger">Ansiedad Severa</span>';
    } elseif ($total >= 19 && $total <= 23) {
        return '<span class="badge bg-warning text-dark">Ansiedad Moderada</span>';
    } elseif ($total < 18) {
        return '<span class="badge bg-success">Ansiedad Leve</span>';
    }
    return $total;
}

function obtenerCategoriaEpworth($total) {
    if ($total >= 9) {
        return '<span class="badge bg-danger">Insomnio Severo</span>';
    } elseif ($total >= 7 && $total <= 8) {
        return '<span class="badge bg-warning text-dark">Insomnio Moderado</span>';
    } elseif ($total <= 6) {
        return '<span class="badge bg-success">Insomnio Leve</span>';
    }
    return $total;
}

function obtenerCategoriaNeuroticismo($valor, $genero) {
    if ($genero == 'Masculino') {
        return $valor > 13 ? '<span class="badge bg-danger">Alterado</span>' : '<span class="badge bg-success">Normal</span>';
    } else {
        return $valor > 16 ? '<span class="badge bg-danger">Alterado</span>' : '<span class="badge bg-success">Normal</span>';
    }
}

function obtenerCategoriaPsicoticismo($valor, $genero) {
    if ($genero == 'Masculino') {
        return $valor > 8 ? '<span class="badge bg-danger">Alterado</span>' : '<span class="badge bg-success">Normal</span>';
    } else {
        return $valor > 7 ? '<span class="badge bg-danger">Alterado</span>' : '<span class="badge bg-success">Normal</span>';
    }
}

function obtenerCategoriaPRP($total) {
    if ($total > 135) {
        return '<span class="badge bg-success">Seguro</span>';
    } elseif ($total < 118) {
        return '<span class="badge bg-danger">Propenso o Inseguro</span>';
    } else {
        return '<span class="badge bg-warning text-dark">Neutro</span>';
    }
}

function evaluarCargo($total, $limiteAlto, $limiteBajo) {
    if ($total > $limiteAlto) return "Seguro";
    elseif ($total < $limiteBajo) return "Propenso o inseguro";
    else return "Neutro";
}

function badgeClase($resultado) {
    switch ($resultado) {
        case 'Seguro':
            return 'badge bg-success';
        case 'Neutro':
            return 'badge bg-warning text-dark';
        case 'Propenso o inseguro':
            return 'badge bg-danger';
        default:
            return 'badge bg-secondary';
    }
}

function obtenerCategoriaBarsit($correctas, $total_preguntas) {
    if ($total_preguntas == 0) {
        return '<span class="badge bg-secondary">No aplica</span>';
    }
    
    $porcentaje = ($correctas / $total_preguntas) * 100;
    
    if ($porcentaje >= 75) {
        return '<span class="badge bg-success">Superior</span>';
    } elseif ($porcentaje >= 50) {
        return '<span class="badge bg-primary">Promedio alto</span>';
    } elseif ($porcentaje >= 25) {
        return '<span class="badge bg-warning">Promedio bajo</span>';
    } else {
        return '<span class="badge bg-danger">Deficiente</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .total-cell {
            font-weight: bold;
        }
        .search-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .badge-cell {
            min-width: 120px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="sidebar p-3">
        <a href="panel.php" class="btn btn-outline-secondary mb-3 w-100">
            <i class="bi bi-arrow-left me-2"></i> Volver al panel
        </a>
    </div>

    
    <div class="main-content">
    <h2 class="mb-4">Resultados del Examen - <?php echo date('d/m/Y', strtotime($fecha_busqueda)); ?></h2>
        
        <!-- Formulario de búsqueda por fecha y OT -->
        <div class="search-box">
            <form method="GET" class="row g-3">
                <input type="hidden" name="examen_id" value="<?php echo $examen_id; ?>">
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Buscar por fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" 
                           value="<?php echo htmlspecialchars($fecha_busqueda); ?>">
                </div>
                <div class="col-md-4">
                    <label for="ot" class="form-label">Buscar por OT:</label>
                    <input type="text" class="form-control" id="ot" name="ot" 
                           value="<?php echo htmlspecialchars($ot_busqueda); ?>" placeholder="Número de OT">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <?php if ($fecha_busqueda != date('Y-m-d') || $ot_busqueda != ''): ?>
                        <a href="?examen_id=<?php echo $examen_id; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reiniciar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <?php if (empty($pacientes)): ?>
                <div class="alert alert-warning">No se encontraron resultados para los criterios de búsqueda.</div>
            <?php else: ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>OT</th>
                            <th>Hora</th>
                            <th>
                                <?php 
                                if ($examen_id == 2) {
                                    echo 'Nivel de Insomnio';
                                } elseif ($examen_id == 6) {
                                    echo 'Nivel de Ansiedad';
                                } elseif ($examen_id == 3) {
                                    echo 'Resultados Barrat';
                                } elseif ($examen_id == 4) {
                                    echo 'Resultado PRP';
                                } else {
                                    echo 'Resultado';
                                }
                                ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($paciente['nombre_paciente']); ?></td>
                                <td><?php echo $paciente['edad']; ?></td>
                                <td><?php echo htmlspecialchars($paciente['genero']); ?></td>
                                <td><?php echo htmlspecialchars($paciente['ot']); ?></td>
                                <td><?php echo date('H:i', strtotime($paciente['fecha'])); ?></td>
                                <td class="total-cell">
                                <?php if ($examen_id == 2): ?>
                                    <?php echo obtenerCategoriaEpworth($paciente['total']); ?>
                                    <small class="text-muted">(<?php echo $paciente['total']; ?>)</small>
                                <?php elseif ($examen_id == 6): ?>
                                    <?php echo obtenerCategoriaHamilton($paciente['total']); ?>
                                    <small class="text-muted">(<?php echo $paciente['total']; ?>)</small>
                                <?php elseif ($examen_id == 3): ?>
                                    <strong><?php echo $paciente['total']; ?></strong>
                                    <br>
                                    <button class="btn btn-sm btn-link" type="button" data-toggle="collapse" data-target="#detalle-<?php echo $paciente['usuario_id']; ?>" aria-expanded="false" aria-controls="detalle-<?php echo $paciente['usuario_id']; ?>">
                                        Ver detalle
                                    </button>
                                    <div class="collapse mt-2" id="detalle-<?php echo $paciente['usuario_id']; ?>">
                                        <ul class="list-group">
                                            <li class="list-group-item">Puntaje Cognitivo: <strong><?php echo $paciente['puntaje_cognitivo']; ?></strong></li>
                                            <li class="list-group-item">Puntaje Motor: <strong><?php echo $paciente['puntaje_motor']; ?></strong></li>
                                            <li class="list-group-item">Puntaje No Planeado: <strong><?php echo $paciente['puntaje_no_planeado']; ?></strong></li>
                                        </ul>
                                    </div>
                                <?php elseif ($examen_id == 4): ?>
                                    <strong><?php echo obtenerCategoriaPRP($paciente['total']); ?></strong>
                                    <small class="text-muted">(<?php echo $paciente['total']; ?>)</small>
                                    <button class="btn btn-sm btn-link" type="button"
                                            data-toggle="collapse"
                                            data-target="#detalle-prp-<?php echo $paciente['usuario_id']; ?>"
                                            aria-expanded="false"
                                            aria-controls="detalle-prp-<?php echo $paciente['usuario_id']; ?>">
                                        Ver detalles por cargo
                                    </button>

                                    <div class="collapse mt-2" id="detalle-prp-<?php echo $paciente['usuario_id']; ?>">
                                        <ul class="list-group">
                                            <?php
                                            $cargos = [
                                                'Mandos intermedios'     => [135, 118],
                                                'Obreros calificados'    => [132, 113],
                                                'Obreros no calificados' => [127, 104],
                                                'Administrativos'        => [136, 117],
                                                'Técnicos'               => [140, 118],
                                            ];

                                            foreach ($cargos as $nombre => [$alto, $bajo]) {
                                                $resultado = evaluarCargo($paciente['total'], $alto, $bajo);
                                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                                        $nombre
                                                        <span class='" . badgeClase($resultado) . "'>$resultado</span>
                                                    </li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                <?php elseif ($examen_id == 7): ?>
                                    <div class="mb-1">
                                        <?php echo obtenerCategoriaBarsit($paciente['total'], $paciente['total_preguntas']); ?>
                                        <small class="text-muted">
                                            (<?php echo $paciente['total']; ?>/<?php echo $paciente['total_preguntas']; ?>)
                                        </small>
                                    </div>
                                    <div class="text-small text-muted">
                                        Respondidas: <?php echo $paciente['respondidas']; ?>/<?php echo $paciente['total_preguntas']; ?>
                                        <?php if ($paciente['respondidas'] < $paciente['total_preguntas']): ?>
                                            <br><span class="text-danger">Incompleto</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php else: ?>
                                        <?php echo $paciente['total']; ?>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if ($examen_id == 2): ?>
                <div class="mt-3">
                    <h5>Escala Epworth:</h5>
                    <ul class="list-unstyled">
                        <li><span class="badge bg-success me-2">Insomnio Leve</span> (0-6 puntos)</li>
                        <li><span class="badge bg-warning text-dark me-2">Insomnio Moderado</span> (7-8 puntos)</li>
                        <li><span class="badge bg-danger me-2">Insomnio Severo</span> (>9  puntos)</li>
                    </ul>
                </div>
            <?php elseif ($examen_id == 6): ?>
                <div class="mt-3">
                    <h5>Escala Hamilton:</h5>
                    <ul class="list-unstyled">
                        <li><span class="badge bg-success me-2">Ansiedad Leve</span> (&lt;18 puntos)</li>
                        <li><span class="badge bg-warning text-dark me-2">Ansiedad Moderada</span> (19-23 puntos)</li>
                        <li><span class="badge bg-danger me-2">Ansiedad Severa</span> (&gt;24 puntos)</li>
                    </ul>
                </div>
            <?php elseif ($examen_id == 1):?>
                <div class="mt-3">
                    <h5>Escala EPQ:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Masculino</h6>
                            <ul class="list-unstyled">
                                <li><span class="badge bg-success me-2">Neuroticismo Normal</span> (0-13 puntos)</li>
                                <li><span class="badge bg-danger me-2">Neuroticismo Alterado</span> (>13 puntos)</li>
                                <li><span class="badge bg-success me-2">Psicoticismo Normal</span> (0-8 puntos)</li>
                                <li><span class="badge bg-danger me-2">Psicoticismo Alterado</span> (>8 puntos)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Femenino</h6>
                            <ul class="list-unstyled">
                                <li><span class="badge bg-success me-2">Neuroticismo Normal</span> (0-16 puntos)</li>
                                <li><span class="badge bg-danger me-2">Neuroticismo Alterado</span> (>16 puntos)</li>
                                <li><span class="badge bg-success me-2">Psicoticismo Normal</span> (0-7 puntos)</li>
                                <li><span class="badge bg-danger me-2">Psicoticismo Alterado</span> (>7 puntos)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php elseif ($examen_id == 4): ?>
                <div class="mt-3">
                    <h5>Escala PRP:</h5>
                    <ul class="list-unstyled">
                        <li><span class="badge bg-success me-2">Seguro</span> (mayor a 135)</li>
                        <li><span class="badge bg-danger me-2">Propenso o Inseguro</span> (menor a 118)</li>
                        <li><span class="badge bg-warning text-dark me-2">Neutro</span> (entre 118 y 135)</li>
                    </ul>
                </div>
                <?php elseif ($examen_id == 7): ?>
                <div class="mt-3">
                    <h5>Escala BARSIT (<?php echo $pacientes[0]['total_preguntas'] ?? '60'; ?> preguntas):</h5>
                    <ul class="list-unstyled">
                        <li><span class="badge bg-success me-2">Superior</span> (75-100%)</li>
                        <li><span class="badge bg-primary me-2">Promedio alto</span> (50-74%)</li>
                        <li><span class="badge bg-warning me-2">Promedio bajo</span> (25-49%)</li>
                        <li><span class="badge bg-danger me-2">Deficiente</span> (0-24%)</li>
                    </ul>
                    <p class="text-muted mt-2">
                        Se muestran: Correctas/Total (Respondidas/Total)
                    </p>
                    <?php if (isset($pacientes[0]) && $pacientes[0]['respondidas'] < $pacientes[0]['total_preguntas']): ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Algunos exámenes están incompletos
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
                
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>