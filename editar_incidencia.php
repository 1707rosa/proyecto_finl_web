<?php
session_start();
require 'php/db_connect.php';
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['validador','administrador'])) {
    header("Location: ../login.php"); exit();
}
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM incidencias WHERE id=?");
$stmt->execute([$id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provincia = $_POST['provincia'];
    $municipio = $_POST['municipio'];
    $muertos = $_POST['muertos'];
    $heridos = $_POST['heridos'];
    $stmt = $conn->prepare("UPDATE incidencias SET provincia=?, municipio=?, muertos=?, heridos=? WHERE id=?");
    $stmt->execute([$provincia,$municipio,$muertos,$heridos,$id]);
    header("Location: validar.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Incidencia</title>
<link rel="stylesheet" href="css/style_super.css">
</head>
<body>
<h2>Editar Reporte</h2>
<form method="post">
    <label>Provincia:</label>
    <input type="text" name="provincia" value="<?= htmlspecialchars($incidencia['provincia']) ?>">
    <label>Municipio:</label>
    <input type="text" name="municipio" value="<?= htmlspecialchars($incidencia['municipio']) ?>">
    <label>Muertos:</label>
    <input type="number" name="muertos" value="<?= $incidencia['muertos'] ?>">
    <label>Heridos:</label>
    <input type="number" name="heridos" value="<?= $incidencia['heridos'] ?>">
    <button type="submit">Guardar cambios</button>
</form>
</body>
</html>
