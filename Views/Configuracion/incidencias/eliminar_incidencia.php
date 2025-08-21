<?php
session_start();
include("../../config/db.php"); // Conexión PDO

if (!isset($_GET['id'])) {
    die("ID no proporcionado.");
}

$id = (int) $_GET['id'];

// Primero borrar la foto si existe
$stmt = $conn->prepare("SELECT foto FROM Incidencias WHERE id=:id");
$stmt->execute(['id'=>$id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($incidencia && !empty($incidencia['foto']) && file_exists($incidencia['foto'])) {
    unlink($incidencia['foto']);
}

// Borrar la incidencia
$stmt = $conn->prepare("DELETE FROM Incidencias WHERE id=:id");
$stmt->execute(['id'=>$id]);

header("Location: ver_incidencias.php");
exit;
