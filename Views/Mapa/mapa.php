<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa de Incidencias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css">
    <link rel="stylesheet" href="../../public/css/styles.css">

</head>

<body class="bg-light">

    <?php include('../../public/Components/navbar.php'); //navbar 
    ?>
    <div class="container-fluid p-3">
        <h3 class="mb-3 text-center">📍 Mapa de Incidencias (últimas 24 horas)</h3>
        <div id="map"></div>
    </div>

    <!-- Modal Detalles -->
    <div class="modal fade" id="incidenciaModal" tabindex="-1" aria-labelledby="incidenciaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="incidenciaModalLabel">Detalles de la Incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 id="titulo"></h4>
                    <p id="descripcion"></p>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Tipo:</strong> <span id="tipo"></span></li>
                        <li class="list-group-item"><strong>Fecha:</strong> <span id="fecha"></span></li>
                        <li class="list-group-item"><strong>Provincia:</strong> <span id="provincia"></span></li>
                        <li class="list-group-item"><strong>Municipio:</strong> <span id="municipio"></span></li>
                        <li class="list-group-item"><strong>Barrio:</strong> <span id="barrio"></span></li>
                        <li class="list-group-item"><strong>Reportado por:</strong> <span id="usuario"></span></li>
                        <li class="list-group-item"><strong>Muertos:</strong> <span id="muertos"></span></li>
                        <li class="list-group-item"><strong>Heridos:</strong> <span id="heridos"></span></li>
                        <li class="list-group-item"><strong>Pérdidas RD$:</strong> <span id="perdida"></span></li>
                        <li class="list-group-item"><a href="#" id="redes" target="_blank">Ver en redes</a></li>
                    </ul>
                    <div class="mt-3 text-center">
                        <img id="foto" src="" alt="Foto incidencia" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('../../public/Components/footer.php'); //navbar 
    ?>

</body>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="../../public/js/map.js"></script>

</html>