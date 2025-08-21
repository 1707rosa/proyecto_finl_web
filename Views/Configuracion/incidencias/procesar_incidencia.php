<?php
session_start();

// Verificar sesión y rol
$usuario_id = $_SESSION['id'] ?? null;
$rol = $_SESSION['rol'] ?? null;

if (!$usuario_id || $rol !== 'reportero') {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acceso Denegado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
<div class="card shadow p-4 text-center">
<h3 class="text-danger mb-3">🚫 Acceso Denegado</h3>
<p>No tienes permisos para registrar una incidencia.</p>
<a href="../Mapa/mapa.php" class="btn btn-primary mt-3">Volver</a>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</html>';
    exit;
}

include("../../../config/db.php");

// Validar campos obligatorios
if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['provincia_id'], $_POST['municipio_id'], $_POST['tipo_id'], $_POST['fecha'])) {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $provincia = (int)$_POST['provincia_id'];
    $municipio = (int)$_POST['municipio_id'];
    $barrio = (int)($_POST['barrio_id'] ?? 0);
    $tipo = (int)$_POST['tipo_id'];
    $fecha = $_POST['fecha'];
    $lat = $_POST['latitud'];
    $lng = $_POST['longitud'];
    $muertos = (int)($_POST['muertos'] ?? 0);
    $heridos = (int)($_POST['heridos'] ?? 0);
    $perdida = (float)($_POST['perdida_estimada_de_RD'] ?? 0);
    $redes = $_POST['redes_link'] ?? '';

    // Manejo de la foto
    $foto_ruta = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $directorio = "../../uploads/";
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);
        $foto_nombre = time() . "_" . basename($_FILES['foto']['name']);
        $foto_ruta = $directorio . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_ruta);
    }

    // Insertar incidencia con PDO
    $sql = "INSERT INTO Incidencias 
        (titulo, descripcion, fecha, muertos, heridos, perdida_estimada_de_RD, redes_link, foto, latitud, longitud, provincia_id, municipio_id, barrio_id, usuario_id, tipo_id)
        VALUES
        (:titulo, :descripcion, :fecha, :muertos, :heridos, :perdida, :redes, :foto, :lat, :lng, :provincia, :municipio, :barrio, :usuario, :tipo)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':muertos', $muertos, PDO::PARAM_INT);
    $stmt->bindParam(':heridos', $heridos, PDO::PARAM_INT);
    $stmt->bindParam(':perdida', $perdida);
    $stmt->bindParam(':redes', $redes);
    $stmt->bindParam(':foto', $foto_ruta);
    $stmt->bindParam(':lat', $lat);
    $stmt->bindParam(':lng', $lng);
    $stmt->bindParam(':provincia', $provincia, PDO::PARAM_INT);
    $stmt->bindParam(':municipio', $municipio, PDO::PARAM_INT);
    $stmt->bindParam(':barrio', $barrio, PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../../Mapa/mapa.php?success=1");
        exit;
    } else {
        header("Location: ../../Mapa/mapa.php?error=1");
        exit;
    }
} else {
    header("Location: ../../Mapa/mapa.php?error_campos=1");
    exit;
}
