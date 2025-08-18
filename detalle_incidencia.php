<?php
session_start();
include 'modules/auth/conexion.php';

// Obtener el ID de la incidencia
$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: lista_incidencias.php");
    exit();
}

// Obtener los datos de la incidencia
$stmt = $conn->prepare("SELECT * FROM incidencias WHERE id = ?");
$stmt->execute([$id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    header("Location: lista_incidencias.php");
    exit();
}

// Coordenadas por defecto (Santo Domingo) si no están definidas
$lat = 18.4861; // Santo Domingo por defecto
$lng = -69.9312;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($incidencia['titulo']); ?> - Detalle</title>
    <link rel="stylesheet" href="css/detalle-styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    <div class="container">
        <!-- Navegación -->
        <nav class="breadcrumb">
            <a href="lista_incidencias.php"><i class="fas fa-list"></i> Lista de Incidencias</a>
            <span class="separator">></span>
            <span class="current">Detalle de Incidencia</span>
        </nav>

        <!-- Encabezado -->
        <header class="detail-header">
            <div class="header-content">
                <h1><?php echo htmlspecialchars($incidencia['titulo']); ?></h1>
                <div class="header-meta">
                    <span class="tipo-badge tipo-<?php echo strtolower(str_replace(' ', '-', $incidencia['tipo'])); ?>">
                        <i class="fas fa-tag"></i>
                        <?php echo htmlspecialchars($incidencia['tipo']); ?>
                    </span>
                    <span class="fecha">
                        <i class="fas fa-calendar"></i>
                        <?php echo date('d/m/Y', strtotime($incidencia['fecha'])); ?>
                    </span>
                    <span class="ubicacion">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($incidencia['municipio'] . ', ' . $incidencia['provincia']); ?>
                    </span>
                </div>
            </div>
            <div class="header-actions">
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button onclick="compartir()" class="btn btn-primary">
                    <i class="fas fa-share"></i> Compartir
                </button>
            </div>
        </header>

        <!-- Contenido principal -->
        <div class="detail-content">
            <!-- Columna izquierda: Información -->
            <div class="info-column">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Información General</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>ID de Incidencia:</label>
                            <span>#<?php echo $incidencia['id']; ?></span>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Ocurrencia:</label>
                            <span><?php echo date('d/m/Y', strtotime($incidencia['fecha'])); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Tipo:</label>
                            <span class="tipo-badge tipo-<?php echo strtolower(str_replace(' ', '-', $incidencia['tipo'])); ?>">
                                <?php echo htmlspecialchars($incidencia['tipo']); ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <label>Provincia:</label>
                            <span><?php echo htmlspecialchars($incidencia['provincia']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Municipio:</label>
                            <span><?php echo htmlspecialchars($incidencia['municipio']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Registrado:</label>
                            <span><?php echo date('d/m/Y H:i', strtotime($incidencia['created_at'])); ?></span>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-file-text"></i> Descripción</h3>
                    <p class="descripcion">
                        <?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?>
                    </p>
                </div>

                <?php if ($incidencia['foto']): ?>
                <div class="info-card">
                    <h3><i class="fas fa-camera"></i> Evidencia Fotográfica</h3>
                    <div class="photo-container">
                        <img src="<?php echo htmlspecialchars($incidencia['foto']); ?>" 
                             alt="Foto de la incidencia" 
                             class="incidencia-photo"
                             onclick="openPhotoModal(this.src)">
                        <div class="photo-overlay">
                            <i class="fas fa-expand"></i>
                            <span>Click para ampliar</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna derecha: Mapa -->
            <div class="map-column">
                <div class="map-card">
                    <h3><i class="fas fa-map"></i> Ubicación</h3>
                    <div id="map" class="map-container"></div>
                    <div class="map-info">
                        <p><strong>Coordenadas:</strong> 
                           <?php echo number_format($lat, 6); ?>, <?php echo number_format($lng, 6); ?>
                        </p>
                        <button onclick="centrarMapa()" class="btn btn-sm btn-outline">
                            <i class="fas fa-crosshairs"></i> Centrar mapa
                        </button>
                        <button onclick="abrirEnGoogleMaps()" class="btn btn-sm btn-outline">
                            <i class="fas fa-external-link-alt"></i> Abrir en Google Maps
                        </button>
                    </div>
                </div>

                <!-- Botón de volver -->
                <div class="map-card">
                    <h3><i class="fas fa-arrow-left"></i> Navegación</h3>
                    <a href="lista_incidencias.php" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-arrow-left"></i> Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ampliar foto -->
    <div id="photoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePhotoModal()">&times;</span>
            <img id="modalPhoto" src="" alt="Foto ampliada">
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Variables de PHP para JavaScript
        const incidenciaData = {
            id: <?php echo $incidencia['id']; ?>,
            titulo: <?php echo json_encode($incidencia['titulo']); ?>,
            lat: <?php echo $lat; ?>,
            lng: <?php echo $lng; ?>,
            tipo: <?php echo json_encode($incidencia['tipo']); ?>,
            descripcion: <?php echo json_encode($incidencia['descripcion']); ?>
        };

        // Inicializar mapa
        let map = L.map('map').setView([incidenciaData.lat, incidenciaData.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Agregar marcador de la incidencia
        const marker = L.marker([incidenciaData.lat, incidenciaData.lng])
            .addTo(map)
            .bindPopup(`
                <strong>${incidenciaData.titulo}</strong><br>
                <em>${incidenciaData.tipo}</em><br>
                ${incidenciaData.descripcion.substring(0, 100)}...
            `);

        // Funciones del mapa
        function centrarMapa() {
            map.setView([incidenciaData.lat, incidenciaData.lng], 15);
        }

        function abrirEnGoogleMaps() {
            const url = `https://www.google.com/maps/search/?api=1&query=${incidenciaData.lat},${incidenciaData.lng}`;
            window.open(url, '_blank');
        }

        // Funciones del modal de foto
        function openPhotoModal(src) {
            const modal = document.getElementById('photoModal');
            const modalPhoto = document.getElementById('modalPhoto');
            modalPhoto.src = src;
            modal.style.display = 'block';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.style.display = 'none';
        }

        // Cerrar modal al hacer click fuera de la imagen
        window.onclick = function(event) {
            const modal = document.getElementById('photoModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Función para compartir
        function compartir() {
            if (navigator.share) {
                navigator.share({
                    title: incidenciaData.titulo,
                    text: `Incidencia reportada: ${incidenciaData.tipo}`,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('URL copiada al portapapeles');
                });
            }
        }

        // Redimensionar mapa cuando se carga la página
        window.addEventListener('load', function() {
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
</body>
</html>