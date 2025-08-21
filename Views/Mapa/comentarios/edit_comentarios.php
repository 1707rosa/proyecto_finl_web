<?php
session_start();
include("../../../config/db.php");


$id = $_POST['id'] ?? 0;
$comentario = $_POST['comentario'] ?? '';
$usuario_id = $_SESSION['id'] ?? 0;

if (!$id || !$comentario || !$usuario_id) {
    echo json_encode(["status" => "error", "msg" => "Datos incompletos"]);
    exit;
}

$stmt = $conn->prepare("UPDATE Comentarios SET Contenido = ? WHERE id = ? AND usuarios_id = ?");
$stmt->execute([$comentario, $id, $usuario_id]);

echo json_encode(["status" => "ok"]);