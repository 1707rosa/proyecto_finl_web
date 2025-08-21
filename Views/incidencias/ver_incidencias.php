<?php
include("../../config/db.php"); // Conexión a la base de datos

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
    i.foto,
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
<<<<<<< HEAD:Views/incidencias/ver_incidencias.php
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/styles.css">
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/ver_incidencias.php
</head>

<body>
    <?php include('../../public/Components/navbar.php'); ?>

    <div class="container-fluid">
        <div class="p-2 m-2 d-flex justify-content-between align-items-center">
            <h2 class="text-primary">Incidencias Registradas</h2>
            <a class="btn btn-primary" href="./registro_incidencia.php">Registrar Incidencia</a>
        </div>
        
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
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
                    <th>Acciones</th>
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
                        <td class="text-center">
                            <?php if (!empty($row['foto'])): ?>
                                <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="editar_incidencia.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_incidencia.php?id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Seguro que deseas eliminar esta incidencia?');">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include('../../public/Components/footer.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</html>
