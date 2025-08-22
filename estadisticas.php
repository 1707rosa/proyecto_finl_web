<?php
session_start();
require './config/db.php';
if (!isset($_SESSION['rol'])) { header("Location: config/modules/auth/login.php"); exit(); }
$tipos = $conn->query("SELECT nombre, COUNT(*) as total FROM incidencias GROUP BY nombre_tipo")->fetchAll(PDO::FETCH_ASSOC);
$labels = json_encode(array_column($tipos,'nombre'));
$datos = json_encode(array_column($tipos,'total'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Estadísticas</title>
<link rel="stylesheet" href="css/style_super.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h2>Estadísticas de Incidencias</h2>
<div class="chart-container">
    <canvas id="graficoIncidencias"></canvas>
</div>
<script>
const ctx = document.getElementById('graficoIncidencias').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: { labels: <?= $labels ?>, datasets: [{ label:'# de incidencias', data: <?= $datos ?>, backgroundColor:'rgba(54,162,235,0.5)', borderColor:'rgba(54,162,235,1)', borderWidth:1 }]},
    options: { scales:{y:{beginAtZero:true}} }
});
</script>
</body>
</html>
