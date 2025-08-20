<?php
session_start();
require 'php/db_connect.php';
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['validador','administrador'])) {
    header("Location: ../login.php"); exit();
}
$stmt = $conn->prepare("SELECT * FROM incidencias WHERE aprobado=0 ORDER BY fecha DESC");
$stmt->execute();
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Validar Reportes</title>
<link rel="stylesheet" href="css/style_super.css">
</head>
<body>
<h2>Reportes Pendientes</h2>
<table>
<tr>
    <th>ID</th><th>Título</th><th>Provincia</th><th>Municipio</th><th>Acciones</th>
</tr>
<?php foreach($reportes as $r): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= htmlspecialchars($r['titulo']) ?></td>
    <td><?= htmlspecialchars($r['provincia']) ?></td>
    <td><?= htmlspecialchars($r['municipio']) ?></td>
    <td>
        <a href="editar_incidencia.php?id=<?= $r['id'] ?>">Editar</a> | 
        <a href="php/update.php?action=aprobar&id=<?= $r['id'] ?>">Aprobar</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
