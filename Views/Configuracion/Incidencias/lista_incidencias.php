<?php
session_start();
include("../../../config/db.php");

// Obtener filtros
$filtro_provincia = $_GET['provincia'] ?? '';
$filtro_tipo = $_GET['tipo'] ?? '';
$filtro_fecha_inicio = $_GET['fecha_inicio'] ?? '';
$filtro_fecha_fin = $_GET['fecha_fin'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

// Consulta 
$sql = "SELECT 
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
WHERE 1=1";

$params = [];

if (!empty($filtro_provincia)) {
    $sql .= " AND p.nombre LIKE ?";
    $params[] = "%$filtro_provincia%";
}

if (!empty($filtro_tipo)) {
    $sql .= " AND t.nombre LIKE ?";
    $params[] = "%$filtro_tipo%";
}

if (!empty($filtro_fecha_inicio)) {
    $sql .= " AND i.fecha >= ?";
    $params[] = $filtro_fecha_inicio;
}

if (!empty($filtro_fecha_fin)) {
    $sql .= " AND i.fecha <= ?";
    $params[] = $filtro_fecha_fin;
}

if (!empty($busqueda)) {
    $sql .= " AND (i.titulo LIKE ? OR i.descripcion LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}

$sql .= " ORDER BY i.fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener provincias unicas para el select
$stmt_provincias = $conn->query("SELECT DISTINCT nombre FROM Provincias ORDER BY nombre");
$provincias = $stmt_provincias->fetchAll(PDO::FETCH_COLUMN);

// Obtener tipos unicos para el select
$stmt_tipos = $conn->query("SELECT DISTINCT nombre FROM Tipos_incidencias ORDER BY nombre");
$tipos = $stmt_tipos->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/lista-styles.css">
</head>
<body>
    <?php include('../../../public/Components/navbar.php'); ?>
    
    <div class="container">
        <header class="page-header mt-4">
            <h1><i class="fas fa-list"></i> Lista de Incidencias</h1>
        </header>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="busqueda">Búsqueda</label>
                            <input type="text" class="form-control" id="busqueda" name="busqueda" 
                                   placeholder="Buscar por título o descripción..." 
                                   value="<?php echo htmlspecialchars($busqueda); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="provincia">Provincia</label>
                            <select class="form-control" id="provincia" name="provincia">
                                <option value="">Todas</option>
                                <?php foreach ($provincias as $provincia): ?>
                                    <option value="<?php echo htmlspecialchars($provincia); ?>" 
                                            <?php echo ($filtro_provincia === $provincia) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($provincia); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="">Todos</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo); ?>" 
                                            <?php echo ($filtro_tipo === $tipo) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="fecha_inicio">Fecha desde</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                                   value="<?php echo htmlspecialchars($filtro_fecha_inicio); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="fecha_fin">Fecha hasta</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                                   value="<?php echo htmlspecialchars($filtro_fecha_fin); ?>">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <a href="lista_incidencias.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="card">
            <div class="card-header">
                <h5>Resultados: <?php echo count($incidencias); ?> incidencia(s)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($incidencias)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5>No se encontraron incidencias</h5>
                        <p class="text-muted">Intenta modificar los filtros de búsqueda</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Provincia</th>
                                    <th>Municipio</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incidencias as $incidencia): ?>
                                    <tr>
                                        <td><?php echo $incidencia['id']; ?></td>
                                        <td><?php echo htmlspecialchars($incidencia['titulo']); ?></td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?php echo htmlspecialchars($incidencia['tipo_incidencia']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($incidencia['provincia']); ?></td>
                                        <td><?php echo htmlspecialchars($incidencia['municipio']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($incidencia['fecha'])); ?></td>
                                        <td>
                                            <a href="detalle_incidencia.php?id=<?php echo $incidencia['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('../../../public/Components/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>