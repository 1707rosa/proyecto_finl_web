<?php

session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa de Incidencias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css">
    <link rel="stylesheet" href="../../public/css/styles.css">

</head>

<body class="bg-light">

    <?php include('../../public/Components/navbar.php'); //navbar 
    ?>
    <div class="container-fluid p-2">
        <div class=" mb-3 d-flex flex-column aling-items-start justify-content-center">
            <h3 class="text-center">📍 Mapa de Incidencias (últimas 24 horas)</h3>
            <!-- Botón para abrir el modal -->
            <?php
            if ($_SESSION['rol'] == 'reportero' || $_SESSION['rol'] == 'admin') {

                echo '
                <button class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#nuevoModal">
                <i class="bi bi-plus-circle"></i> Nueva Incidencia
                </button>';
            }
            ?>
        </div>
        <div id="map"></div>
    </div>

    <!-- Modal Detalles -->
    <div class="modal fade" id="incidenciaModal" tabindex="-1" aria-labelledby="incidenciaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="incidenciaModalLabel">Detalles de la Incidencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
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
                        <li class="list-group-item"><strong>Redes:</strong> <span id="redes"></span></li>
                    </ul>

                    <div class="mt-3 text-center">
                        <img id="foto" src="" alt="Foto incidencia" class="img-fluid rounded">
                    </div>

                    <hr>

                    <!-- Comentarios -->
                    <h5>Comentarios</h5>
                    <ul id="comentariosList" class="list-group mb-3"></ul>

                    <!-- Agregar comentario -->
                    <form id="formComentario">
                        <input type="hidden" id="inc_id" name="inc_id">
                        <textarea class="form-control mb-2" name="comentario" id="comentario" placeholder="Escribe un comentario..." required></textarea>
                        <button type="submit" class="btn btn-success">Agregar Comentario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="nuevoModalLabel">Registrar Nueva Incidencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../Configuracion/incidencias/procesar_incidencia.php" method="POST" enctype="multipart/form-data" id="formIncidencia">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Título</label>
                                    <input type="text" name="titulo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Descripción</label>
                                    <textarea name="descripcion" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Incidencia</label>
                                    <select name="tipo_id" class="form-control" required>
                                        <option value="">-- Selecciona --</option>
                                        <?php
                                        include('../../config/db.php');
                                        $tipos = $conn->query("SELECT * FROM Tipos_incidencias")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($tipos as $tipo) {
                                            echo "<option value='{$tipo['id']}'>{$tipo['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Provincia</label>
                                    <select id="provinciaSelect" name="provincia_id" class="form-control" required>
                                        <option value="">-- Selecciona --</option>
                                        <?php
                                        $provincias = $conn->query("SELECT * FROM Provincias")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($provincias as $prov) {
                                            echo "<option value='{$prov['id']}'>{$prov['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Municipio</label>
                                    <select id="municipioSelect" name="municipio_id" class="form-control" required></select>
                                </div>
                                <div class="mb-3">
                                    <label>Barrio</label>
                                    <select id="barrioSelect" name="barrio_id" class="form-control" required></select>
                                </div>
                                <div class="mb-3">
                                    <label>Muertos</label>
                                    <input type="number" name="muertos" class="form-control" min="0" value="0">
                                </div>
                                <div class="mb-3">
                                    <label>Heridos</label>
                                    <input type="number" name="heridos" class="form-control" min="0" value="0">
                                </div>
                                <div class="mb-3">
                                    <label>Pérdida estimada (RD$)</label>
                                    <input type="number" name="perdida_estimada_de_RD" step="0.01" class="form-control" value="0">
                                </div>
                                <div class="mb-3">
                                    <label>Redes (link)</label>
                                    <input type="url" name="redes_link" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                                    <img id="preview" style="display:none; max-width:200px; margin-top:10px;">
                                </div>
                                <input type="hidden" name="latitud" id="lat">
                                <input type="hidden" name="longitud" id="lng">
                                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['id']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Selecciona ubicación en el mapa:</label>
                                <div id="mapNuevo" style="height:500px;"></div>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success">Registrar Incidencia</button>
                        </div>
                    </form>
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
<script>
    window.usuarioId = <?= $_SESSION['id'] ?? 0 ?>;
</script>
<script src="../../public/js/comentarios.js"></script>

</html>