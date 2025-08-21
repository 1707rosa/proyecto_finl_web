<?php 

include('../../config/db.php');
$provincia_id = $_GET['provincia_id'];
$municipios = $conn->prepare("SELECT id, nombre FROM Municipios WHERE provincia_id=?");
$municipios->execute([$provincia_id]);
echo json_encode($municipios->fetchAll(PDO::FETCH_ASSOC));


?>