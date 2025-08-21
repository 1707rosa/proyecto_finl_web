<?php
session_start();
include("../../../config/db.php");

$id = $_POST['id'] ?? 0;
$usuario_id = $_SESSION['id'] ?? 0;

if (!$id || !$usuario_id) {
    echo json_encode(["status" => "error", "msg" => "Datos incompletos"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM Comentarios WHERE id = ? AND usuarios_id = ?");
$stmt->execute([$id, $usuario_id]);

echo json_encode(["status" => "ok"]);