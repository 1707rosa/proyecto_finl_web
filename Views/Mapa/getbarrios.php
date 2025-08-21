<?php

// fetch_barrios.php
include('../../config/db.php');
$municipio_id = $_GET['municipio_id'];
$barrios = $conn->prepare("SELECT id, nombre FROM Barrios WHERE municipio_id=?");
$barrios->execute([$municipio_id]);
echo json_encode($barrios->fetchAll(PDO::FETCH_ASSOC));
