<?php
include('../../config/db.php');
session_start();

// Consulta solo para JSON
$correcciones = $conn->query("
    SELECT c.id, c.incidencias_id, c.campo, c.sugerencia, c.estado,
           u.nombre AS usuario_nombre, u.apellido AS usuario_apellido
    FROM Correcciones c
    JOIN Usuarios u ON u.id = c.usuarios_id
    ORDER BY c.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Forzar que sea JSON
header('Content-Type: application/json');
echo json_encode($correcciones);
