<?php
include("../config/db.php"); // Conexión a la base de datos

// Consulta con todas las relaciones
$sql = "
 SELECT 
    i.id,
    i.titulo,
    i.descripcion,
    i.fecha,
    i.muertos,
    i.heridos,
    i.perdida_estimada_de_RD,
    i.latitud,
    i.longitud,
    i.foto,  -- importante incluir la columna foto si existe en la tabla Incidencias
    p.nombre AS provincia,
    m.nombre AS municipio,
    b.nombre AS barrio,
    u.nombre AS usuario,
    t.nombre AS tipo_incidencia
FROM Incidencias i
INNER JOIN Provincias p ON i.provincia_id = p.id
INNER JOIN Municipios m ON i.municipio_id = m.id
INNER JOIN Barrios b ON i.barrio_id = b.id
INNER JOIN Usuarios u ON i.usuario_id = u.id
INNER JOIN Tipos_incidencias t ON i.tipo_id = t.id
ORDER BY i.fecha DESC
";

// Ejecutamos la consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Incidencias Registradas</title>
    <style>
        img {
            max-width: 100px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
    <?php include('../public/Components/navbar.php'); ?>

    <div class="container-fluid">
        <div class="p-2 m-2">
            <h2 class="text-center text-primary">Incidencias Registradas</h2>
            <a class="btn btn-primary" href="./registro_incidencia.php">Registrar Incidencia</a>
        </div>
        <table class="table m-1">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Provincia</th>
                    <th>Municipio</th>
                    <th>Barrio</th>
                    <th>Tipo</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Foto</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['titulo']) ?></td>
                        <td><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td><?= htmlspecialchars($row['provincia']) ?></td>
                        <td><?= htmlspecialchars($row['municipio']) ?></td>
                        <td><?= htmlspecialchars($row['barrio']) ?></td>
                        <td><?= htmlspecialchars($row['tipo_incidencia']) ?></td>
                        <td><?= htmlspecialchars($row['usuario']) ?></td>
                        <td><?= htmlspecialchars($row['fecha']) ?></td>
                        <td>
                            <?php if (!empty($row['foto'])): ?>
                                <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include('../public/Components/footer.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>