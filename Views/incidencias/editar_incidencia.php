<?php
session_start();
include("../config/db.php"); // Conexión PDO

// Validar que llegue el ID
if (!isset($_GET['id'])) {
    die("ID de incidencia no proporcionado.");
}

$id = (int) $_GET['id'];

// Traer la incidencia
$stmt = $conn->prepare("
    SELECT * FROM Incidencias WHERE id = :id
");
$stmt->execute(['id' => $id]);
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    die("Incidencia no encontrada.");
}

// Traer provincias, municipios, barrios y tipos
$provincias = $conn->query("SELECT id, nombre FROM Provincias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$municipios = $conn->query("SELECT id, nombre FROM Municipios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$barrios = $conn->query("SELECT id, nombre FROM Barrios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$tipos = $conn->query("SELECT id, nombre FROM Tipos_incidencias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

// Guardar cambios si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $provincia_id = $_POST['provincia_id'];
    $municipio_id = $_POST['municipio_id'];
    $barrio_id = $_POST['barrio_id'];
    $tipo_id = $_POST['tipo_id'];
    $fecha = $_POST['fecha'];

    // Manejo de la foto
    $foto_ruta = $incidencia['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $directorio = "../uploads/";
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);
        $foto_nombre = time() . "_" . basename($_FILES['foto']['name']);
        $foto_ruta = $directorio . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_ruta);
    }

    // Actualizar la incidencia
    $update = $conn->prepare("
        UPDATE Incidencias 
        SET titulo=:titulo, descripcion=:descripcion, provincia_id=:provincia_id,
            municipio_id=:municipio_id, barrio_id=:barrio_id, tipo_id=:tipo_id,
            fecha=:fecha, foto=:foto
        WHERE id=:id
    ");

    $update->execute([
        'titulo'=>$titulo,
        'descripcion'=>$descripcion,
        'provincia_id'=>$provincia_id,
        'municipio_id'=>$municipio_id,
        'barrio_id'=>$barrio_id,
        'tipo_id'=>$tipo_id,
        'fecha'=>$fecha,
        'foto'=>$foto_ruta,
        'id'=>$id
    ]);

    header("Location: ver_incidencias.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('../public/Components/navbar.php'); ?>

<div class="container mt-3">
    <h2 class="text-primary">Editar Incidencia</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($incidencia['titulo']) ?>" required>
        </div>
        <div class="mb-2">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($incidencia['descripcion']) ?></textarea>
        </div>
        <div class="mb-2">
            <label>Provincia</label>
            <select name="provincia_id" class="form-control" required>
                <?php foreach($provincias as $prov): ?>
                    <option value="<?= $prov['id'] ?>" <?= $prov['id']==$incidencia['provincia_id']?'selected':'' ?>><?= htmlspecialchars($prov['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>Municipio</label>
            <select name="municipio_id" class="form-control" required>
                <?php foreach($municipios as $mun): ?>
                    <option value="<?= $mun['id'] ?>" <?= $mun['id']==$incidencia['municipio_id']?'selected':'' ?>><?= htmlspecialchars($mun['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>Barrio</label>
            <select name="barrio_id" class="form-control" required>
                <?php foreach($barrios as $barr): ?>
                    <option value="<?= $barr['id'] ?>" <?= $barr['id']==$incidencia['barrio_id']?'selected':'' ?>><?= htmlspecialchars($barr['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>Tipo de incidencia</label>
            <select name="tipo_id" class="form-control" required>
                <?php foreach($tipos as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>" <?= $tipo['id']==$incidencia['tipo_id']?'selected':'' ?>><?= htmlspecialchars($tipo['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?= $incidencia['fecha'] ?>" required>
        </div>
        <div class="mb-2">
            <label>Foto (opcional)</label>
            <input type="file" name="foto" class="form-control">
            <?php if($incidencia['foto']): ?>
                <img src="<?= htmlspecialchars($incidencia['foto']) ?>" style="max-width:150px;margin-top:5px;">
            <?php endif; ?>
        </div>
        <button class="btn btn-success">Guardar Cambios</button>
        <a href="ver_incidencias.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include('../public/Components/footer.php'); ?>
</body>
</html>
