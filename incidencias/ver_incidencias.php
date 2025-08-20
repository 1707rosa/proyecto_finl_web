<?php
include("../config/db.php"); // Conexión a la base de datos

$result = $conn->query("SELECT * FROM incidencias ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Incidencias Registradas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even){background-color: #f2f2f2;}
        img { max-width: 100px; }
    </style>
</head>
<body>
    <h2>Incidencias Registradas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Provincia</th>
            <th>Municipio</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Foto</th>
        </tr>
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['titulo'] ?></td>
            <td><?= $row['descripcion'] ?></td>
            <td><?= $row['provincia'] ?></td>
            <td><?= $row['municipio'] ?></td>
            <td><?= $row['tipo'] ?></td>
            <td><?= $row['fecha'] ?></td>
            <td>
                <?php if($row['foto']): ?>
                    <img src="<?= $row['foto'] ?>" alt="Foto">
                <?php else: ?>
                    Sin foto
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
