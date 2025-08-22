<?php
include('../../config/db.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>Panel Validador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include('../../public/Components/navbar.php'); //navbar 
    ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>Panel de Validador</h3>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>

        <ul class="nav nav-tabs mb-3" id="tabs">
            <li class="nav-item"><a class="nav-link active" href="#correcciones" data-bs-toggle="tab">Correcciones</a></li>
            <li class="nav-item"><a class="nav-link" href="#estadisticas" data-bs-toggle="tab">Estadísticas</a></li>
        </ul>

        <div class="tab-content">
            <!-- CORRECCIONES -->
            <div class="tab-pane fade show active" id="correcciones">
                <?php include('correcciones.php');?>
            </div>

            <!-- ESTADÍSTICAS -->
            <div class="tab-pane fade" id="estadisticas">
                <canvas id="chartIncidencias" height="150"></canvas>
            </div>
        </div>
    </div>
    <?php include('../../public/Components/footer.php'); //footer
    ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../public/js/dashboard.js"></script>

</html>