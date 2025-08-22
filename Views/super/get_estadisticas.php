<?php
include('../../config/db.php');
    

$data = $conn->query("SELECT t.nombre AS tipo, COUNT(i.id) AS total 
    FROM incidencias i 
    JOIN Tipos_incidencias t ON t.id = i.tipo_id
    GROUP BY i.tipo_id")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
