<?php
header('Content-Type: application/json');
require_once('../../config/db.php');

try {
    // Solo incidencias en las últimas 24 horas
    $stmt = $conn->prepare("
        SELECT i.id, i.titulo, i.descripcion, i.fecha, i.latitud, i.longitud, 
               i.muertos, i.heridos, i.perdida_estimada_de_RD,
               i.redes_link, i.foto,
               t.nombre AS tipo,
               p.nombre AS provincia,
               m.nombre AS municipio,
               b.nombre AS barrio,
               u.nombre AS usuario_nombre, u.apellido AS usuario_apellido
        FROM Incidencias i
        INNER JOIN Tipos_incidencias t ON i.tipo_id = t.id
        INNER JOIN Provincias p ON i.provincia_id = p.id
        INNER JOIN Municipios m ON i.municipio_id = m.id
        INNER JOIN Barrios b ON i.barrio_id = b.id
        INNER JOIN Usuarios u ON i.usuario_id = u.id
        
    ");
    $stmt->execute();
    $incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($incidencias);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
