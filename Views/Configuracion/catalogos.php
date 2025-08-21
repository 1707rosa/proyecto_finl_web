<?php
session_start();
require 'php/db_connect.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    header("Location: ../login.php"); exit();
}

// Traer datos
$provincias = $conn->query("SELECT * FROM provincias")->fetchAll(PDO::FETCH_ASSOC);
$tipos = $conn->query("SELECT * FROM tipos_incidencias")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Catálogos</title>
<link rel="stylesheet" href="css/style_super.css">
</head>
<body>
<h2>Administrar Catálogos</h2>

<h3>Provincias</h3>
<form method="post" action="php/catalogos_update.php">
    <input type="text" name="nombre" placeholder="Nueva provincia">
    <input type="hidden" name="tipo" value="provincia">
    <button type="submit">Agregar</button>
</form>
<ul>
<?php foreach($provincias as $p) echo "<li>".htmlspecialchars($p['nombre'])."</li>"; ?>
</ul>

<h3>Tipos de Incidencias</h3>
<form method="post" action="php/catalogos_update.php">
    <input type="text" name="nombre" placeholder="Nuevo tipo">
    <input type="hidden" name="tipo" value="tipo">
    <button type="submit">Agregar</button>
</form>
<ul>
<?php foreach($tipos as $t) echo "<li>".htmlspecialchars($t['nombre'])."</li>"; ?>
</ul>

</body>
</html>
