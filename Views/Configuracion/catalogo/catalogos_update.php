<?php
session_start();
require '../../../config/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    die("Acceso denegado");
}

$tipo = $_POST['tipo'] ?? ($_GET['delete'] ?? '');
$nombre = $_POST['nombre'] ?? null;
$id = $_GET['id'] ?? null;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $nombre) {
        // Insertar registros
        if ($tipo == 'provincia') {
            $stmt = $conn->prepare("INSERT INTO provincias(nombre) VALUES(?)");
        } elseif ($tipo == 'municipio') {
            $stmt = $conn->prepare("INSERT INTO municipios(nombre) VALUES(?)");
        } elseif ($tipo == 'tipo') {
            $stmt = $conn->prepare("INSERT INTO tipos_incidencias(nombre) VALUES(?)");
        }
        $stmt->execute([$nombre]);
    } elseif (isset($_GET['delete']) && $id) {
        // Eliminar registros
        if ($tipo == 'provincia') {
            $stmt = $conn->prepare("DELETE FROM provincias WHERE id=?");
        } elseif ($tipo == 'municipio') {
            $stmt = $conn->prepare("DELETE FROM municipios WHERE id=?");
        } elseif ($tipo == 'tipo') {
            $stmt = $conn->prepare("DELETE FROM tipos_incidencias WHERE id=?");
        }
        $stmt->execute([$id]);
    }
} catch (Exception $e) {
    die("Error en la operación: " . $e->getMessage());
}

header("Location: ../catalogo/catalogos.php");
exit;
