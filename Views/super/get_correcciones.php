<?php
include('../../config/db.php');
session_start();
header('Content-Type: application/json');

$correcciones = $conn->query("
    SELECT c.id, c.incidencias_id, c.campo, c.sugerencia, c.estado,
           u.nombre AS usuario_nombre, u.apellido AS usuario_apellido
    FROM Correcciones c
    JOIN Usuarios u ON u.id = c.usuarios_id
    ORDER BY c.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($correcciones);
