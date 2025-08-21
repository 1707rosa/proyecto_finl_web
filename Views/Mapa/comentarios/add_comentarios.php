<?php
session_start();
include("../../../config/db.php");

$incidencia_id = $_POST['inc_id'] ?? 0;
$usuario_id = $_SESSION['id'] ?? 0;
$comentario = $_POST['comentario'] ?? '';

if (!$incidencia_id || !$usuario_id || !$comentario) {
    echo json_encode(["status" => "error", "msg" => "Datos incompletos"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO Comentarios (Contenido, usuarios_id, incidencias_id, fecha) VALUES (?, ?, ?, NOW())");
$stmt->execute([$comentario, $usuario_id, $incidencia_id]);

echo json_encode(["status" => "ok"]);
