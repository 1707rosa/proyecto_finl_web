<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') die("No autorizado");

$nombre = $_POST['nombre'] ?? '';
$tipo = $_POST['tipo'] ?? '';

if ($tipo == 'provincia') {
    $stmt = $conn->prepare("INSERT INTO provincias(nombre) VALUES(?)");
} elseif ($tipo == 'tipo') {
    $stmt = $conn->prepare("INSERT INTO tipos_incidencias(nombre) VALUES(?)");
} else { die("Tipo inválido"); }

$stmt->execute([$nombre]);
header("Location: ../catalogos.php");
