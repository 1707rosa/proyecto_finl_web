<?php
session_start();
include 'modules/auth/conexion.php';

// Obtener filtros
$filtro_provincia = $_GET['provincia'] ?? '';
$filtro_tipo = $_GET['tipo'] ?? '';
$filtro_fecha_inicio = $_GET['fecha_inicio'] ?? '';
$filtro_fecha_fin = $_GET['fecha_fin'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

// Construir la consulta SQL con filtros
$sql = "SELECT * FROM incidencias WHERE 1=1";
$params = [];

if (!empty($filtro_provincia)) {
    $sql .= " AND provincia LIKE ?";
    $params[] = "%$filtro_provincia%";
}

if (!empty($filtro_tipo)) {
    $sql .= " AND tipo LIKE ?";
    $params[] = "%$filtro_tipo%";
}

if (!empty($filtro_fecha_inicio)) {
    $sql .= " AND fecha >= ?";
    $params[] = $filtro_fecha_inicio;
}

if (!empty($filtro_fecha_fin)) {
    $sql .= " AND fecha <= ?";
    $params[] = $filtro_fecha_fin;
}

if (!empty($busqueda)) {
    $sql .= " AND (titulo LIKE ? OR descripcion LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener provincias únicas para el select
$stmt_provincias = $conn->query("SELECT DISTINCT provincia FROM incidencias ORDER BY provincia");
$provincias = $stmt_provincias->fetchAll(PDO::FETCH_COLUMN);

// Obtener tipos únicos para el select
$stmt_tipos = $conn->query("SELECT DISTINCT tipo FROM incidencias ORDER BY tipo");
$tipos = $stmt_tipos->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Incidencias</title>
    <link rel="stylesheet" href="css/lista-styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="page-header">
            <h1><i class="fas fa-list"></i> Lista de Incidencias</h1>
            <div class="header-actions">
                <a href="incidencias/registro_incidencia.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Incidencia
                </a>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </header>

        <!-- Filtros -->
        <div class="filters-section">
            <form method="GET" action="" class="filters-form">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="busqueda"><i class="fas fa-search"></i> Búsqueda</label>
                        <input type="text" id="busqueda" name="busqueda" 
                               placeholder="Buscar por título o descripción..." 
                               value="<?php echo htmlspecialchars($busqueda); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="provincia"><i class="fas fa-map-marker-alt"></i> Provincia</label>
                        <select id="provincia" name="provincia">
                            <option value="">Todas las provincias</option>
                            <?php foreach ($provincias as $provincia): ?>
                                <option value="<?php echo htmlspecialchars($provincia); ?>" 
                                        <?php echo ($filtro_provincia === $provincia) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($provincia); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="tipo"><i class="fas fa-tags"></i> Tipo</label>
                        <select id="tipo" name="tipo">
                            <option value="">Todos los tipos</option>
                            <?php foreach ($tipos as $tipo): ?>
                                <option value="<?php echo htmlspecialchars($tipo); ?>" 
                                        <?php echo ($filtro_tipo === $tipo) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tipo); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="fecha_inicio"><i class="fas fa-calendar-alt"></i> Fecha desde</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" 
                               value="<?php echo htmlspecialchars($filtro_fecha_inicio); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="fecha_fin"><i class="fas fa-calendar-alt"></i> Fecha hasta</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" 
                               value="<?php echo htmlspecialchars($filtro_fecha_fin); ?>">
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="lista_incidencias.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Resultados -->
        <div class="results-section">
            <div class="results-header">
                <h3>
                    <i class="fas fa-list-ul"></i> 
                    Resultados: <?php echo count($incidencias); ?> incidencia(s) encontrada(s)
                </h3>
                <div class="view-options">
                    <button class="view-btn active" data-view="list">
                        <i class="fas fa-list"></i> Lista
                    </button>
                    <button class="view-btn" data-view="grid">
                        <i class="fas fa-th"></i> Cuadrícula
                    </button>
                </div>
            </div>

            <?php if (empty($incidencias)): ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No se encontraron incidencias</h3>
                    <p>Intenta modificar los filtros de búsqueda</p>
                </div>
            <?php else: ?>
                <div class="incidencias-container list-view">
                    <?php foreach ($incidencias as $incidencia): ?>
                        <div class="incidencia-card">
                            <div class="card-header">
                                <div class="incidencia-info">
                                    <h3 class="incidencia-titulo">
                                        <a href="detalle_incidencia.php?id=<?php echo $incidencia['id']; ?>">
                                            <?php echo htmlspecialchars($incidencia['titulo']); ?>
                                        </a>
                                    </h3>
                                    <div class="incidencia-meta">
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
                                <?php if ($incidencia['foto']): ?>
                                    <div class="incidencia-image">
                                        <img src="<?php echo htmlspecialchars($incidencia['foto']); ?>" 
                                             alt="Foto de la incidencia" 
                                             loading="lazy">
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body">
                                <p class="incidencia-descripcion">
                                    <?php echo htmlspecialchars(substr($incidencia['descripcion'], 0, 200)); ?>
                                    <?php if (strlen($incidencia['descripcion']) > 200): ?>...<?php endif; ?>
                                </p>
                            </div>
                            
                            <div class="card-footer">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    Registrado el <?php echo date('d/m/Y H:i', strtotime($incidencia['created_at'])); ?>
                                </small>
                                <a href="detalle_incidencia.php?id=<?php echo $incidencia['id']; ?>" 
                                   class="btn btn-outline">
                                    <i class="fas fa-eye"></i> Ver detalles
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Cambiar vista entre lista y cuadrícula
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const view = this.dataset.view;
                const container = document.querySelector('.incidencias-container');
                
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                container.className = `incidencias-container ${view}-view`;
            });
        });
    </script>
</body>
</html>