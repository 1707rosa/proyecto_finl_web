<?php
include("../../../config/db.php");

$incidencia_id = $_GET['incidencia_id'] ?? 0;

$stmt = $conn->prepare("
    SELECT c.id, c.Contenido, c.fecha, c.usuarios_id, u.nombre AS usuario_nombre ,u.apellido as usuario_apellido
    FROM Comentarios c
    JOIN Usuarios u ON c.usuarios_id = u.id
    WHERE c.incidencias_id = ?
    ORDER BY c.fecha ASC
");
$stmt->execute([$incidencia_id]);
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($comentarios);
?>