<?php
include("../config/db.php"); // Conexión a la base de datos

$result = $conn->query("SELECT * FROM incidencias ORDER BY fecha DESC");


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
    <?php include('../public/Components/navbar.php'); //navbar 
    ?>

    <div class="container-fluid">
        <div class="p-2 m-2">
            <h2 class="text-center text-primary">Incidencias Registradas</h2>
            <a class="btn btn-primary" href="./registro_incidencia.php">Registrar Incidencia</a>
        </div>
        <table class="table m-1">
            <thead class="table-primary">
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Provincia</th>
                <th>Municipio</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Foto</th>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['titulo'] ?></td>
                        <td><?= $row['descripcion'] ?></td>
                        <td><?= $row['provincia'] ?></td>
                        <td><?= $row['municipio'] ?></td>
                        <td><?= $row['tipo'] ?></td>
                        <td><?= $row['fecha'] ?></td>
                        <td>
                            <?php if ($row['foto']): ?>
                                <img src="<?= $row['foto'] ?>" alt="Foto">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include('../public/Components/footer.php'); //footer 
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>