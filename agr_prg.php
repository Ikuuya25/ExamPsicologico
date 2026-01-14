<?php
session_start();
include 'config.php';
include 'config/auth.php';

$examenes = $conn->query("SELECT id, nombre FROM examenes");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examen_id = $_POST['examen_id'];
    $pregunta = $_POST['pregunta'];
    $tipo = $_POST['tipo'];
    $opciones = $tipo === 'opcion_multiple' ? json_encode(explode(',', $_POST['opciones'])) : null;

    $stmt = $conn->prepare("INSERT INTO preguntas (examen_id, pregunta, tipo, opciones) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $examen_id, $pregunta, $tipo, $opciones);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Pregunta agregada correctamente'); window.location.href='panel.php';</script>";
}
?>

<form method="POST">
    <label>Selecciona un Examen:</label>
    <select name="examen_id" required>
        <?php while ($row = $examenes->fetch_assoc()) { ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nombre']) ?></option>
        <?php } ?>
    </select>

    <label>Pregunta:</label>
    <input type="text" name="pregunta" required>

    <label>Tipo de Pregunta:</label>
    <select name="tipo" id="tipo_pregunta" required>
        <option value="texto">Texto</option>
        <option value="opcion_multiple">Opción Múltiple</option>
        <option value="booleano">Sí/No</option>
    </select>

    <div id="opciones_container" style="display: none;">
        <label>Opciones (separadas por coma):</label>
        <input type="text" name="opciones">
    </div>

    <button type="submit">Agregar Pregunta</button>
</form>

<script>
document.getElementById("tipo_pregunta").addEventListener("change", function() {
    document.getElementById("opciones_container").style.display = this.value === "opcion_multiple" ? "block" : "none";
});
</script>
