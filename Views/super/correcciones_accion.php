<?php
include('../../config/db.php');
session_start();

$action = $_GET['action'] ?? '';

if ($action === 'add') {
    $stmt = $conn->prepare("INSERT INTO Correcciones (incidencias_id, campo, sugerencia, estado, usuarios_id) VALUES (?, ?, ?, 'pendiente', ?)");
    $stmt->execute([$_POST['incidencias_id'], $_POST['campo'], $_POST['sugerencia'], $_POST['usuarios_id']]);
    echo json_encode(['status' => 'ok']);
}

if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM Correcciones WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    echo json_encode(['status' => 'ok']);
}

if ($action === 'update') {
    $stmt = $conn->prepare("UPDATE Correcciones SET estado = ? WHERE id = ?");
    $stmt->execute([$_GET['estado'], $_GET['id']]);
    echo json_encode(['status' => 'ok']);
}
