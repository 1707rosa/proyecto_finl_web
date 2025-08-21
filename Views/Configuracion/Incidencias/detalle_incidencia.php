<?php
session_start();
include("../../../config/db.php");

$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: lista_incidencias.php");
    exit();
}

// Consulta 
$stmt = $conn->prepare("
    SELECT 
        i.*,
        p.nombre as provincia,
        m.nombre as municipio,
        b.nombre as barrio,
        t.nombre as tipo,
        u.nombre as usuario
    FROM Incidencias i
    LEFT JOIN Provincias p ON i.provincia_id = p.id
    LEFT JOIN Municipios m ON i.municipio_id = m.id
    LEFT JOIN Barrios b ON i.barrio_id = b.id
    LEFT JOIN Tipos_incidencias t ON i.tipo_id = t.id
    LEFT JOIN Usuarios u ON i.usuario_id = u.id
    WHERE i.id = ?
");
$stmt->execute([$id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    header("Location: lista_incidencias.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($incidencia['titulo']); ?> - Detalle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/detalle-styles.css">
</head>
<body>
    <?php include('../../../public/Components/navbar.php'); ?>
    
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="lista_incidencias.php">Lista de Incidencias</a></li>
                <li class="breadcrumb-item active">Detalle</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <h2><?php echo htmlspecialchars($incidencia['titulo']); ?></h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> <?php echo $incidencia['id']; ?></p>
                        <p><strong>Tipo:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($incidencia['tipo']); ?></span></p>
                        <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($incidencia['fecha'])); ?></p>
                        <p><strong>Provincia:</strong> <?php echo htmlspecialchars($incidencia['provincia']); ?></p>
                        <p><strong>Municipio:</strong> <?php echo htmlspecialchars($incidencia['municipio']); ?></p>
                        <p><strong>Barrio:</strong> <?php echo htmlspecialchars($incidencia['barrio']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Muertos:</strong> <?php echo $incidencia['muertos'] ?? 0; ?></p>
                        <p><strong>Heridos:</strong> <?php echo $incidencia['heridos'] ?? 0; ?></p>
                        <p><strong>Pérdidas estimadas:</strong> RD$ <?php echo number_format($incidencia['perdida_estimada_de_RD'] ?? 0, 2); ?></p>
                        <p><strong>Reportado por:</strong> <?php echo htmlspecialchars($incidencia['usuario']); ?></p>
                        <p><strong>Coordenadas:</strong> <?php echo $incidencia['latitud']; ?>, <?php echo $incidencia['longitud']; ?></p>
                    </div>
                </div>
                
                <hr>
                
                <h5>Descripción</h5>
                <p><?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></p>
                
                <?php if ($incidencia['foto']): ?>
                    <hr>
                    <h5>Evidencia fotográfica</h5>
                    <img src="<?php echo htmlspecialchars($incidencia['foto']); ?>" class="img-fluid" alt="Foto de la incidencia">
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="lista_incidencias.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a la lista
                </a>
            </div>
        </div>
    </div>

    <?php include('../../../public/Components/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>