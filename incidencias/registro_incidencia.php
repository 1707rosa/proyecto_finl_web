<?php
session_start();
include("../config/db.php"); // Conexión PDO

// Traer provincias, municipios y tipos de la base de datos
$provincias = $conn->query("SELECT id, nombre FROM Provincias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$municipios = $conn->query("SELECT id, nombre FROM Municipios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$barrios= $conn->query("SELECT id, nombre FROM Barrios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$tipos = $conn->query("SELECT id, nombre FROM Tipos_incidencias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
<?php include('../public/Components/navbar.php'); ?>

<div class="container mt-3">
    <h2 class="text-primary">Registrar Incidencia</h2>

    <form action="procesar_incidencia.php" method="POST" enctype="multipart/form-data">

        <div class="form-group mb-2">
            <label class="required">Título</label>
            <input type="text" name="titulo" class="form-control" placeholder="Ej: Accidente en autopista" required>
        </div>

        <div class="form-group mb-2">
            <label class="required">Descripción</label>
            <textarea name="descripcion" class="form-control" placeholder="Describe lo ocurrido..." required></textarea>
        </div>

        <div class="form-group mb-2">
            <label class="required">Provincia</label>
            <select name="provincia_id" class="form-control" required>
                <option value="">-- Selecciona Provincia --</option>
                <?php foreach($provincias as $prov): ?>
                    <option value="<?= $prov['id'] ?>"><?= htmlspecialchars($prov['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="required">Municipio</label>
            <select name="municipio_id" class="form-control" required>
                <option value="">-- Selecciona Municipio --</option>
                <?php foreach($municipios as $mun): ?>
                    <option value="<?= $mun['id'] ?>"><?= htmlspecialchars($mun['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

         <div class="form-group mb-2">
            <label class="required">Barrio</label>
            <select name="barrio_id" class="form-control" required>
                <option value="">-- Selecciona Barrio --</option>
                <?php foreach($barrios as $barrio): ?>
                    <option value="<?= $barrio['id'] ?>"><?= htmlspecialchars($barrio['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="required">Tipo de incidencia</label>
            <select name="tipo_id" class="form-control" required>
                <option value="">-- Selecciona Tipo --</option>
                <?php foreach($tipos as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="required">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Foto (opcional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
            <img id="preview" src="#" alt="Vista previa" style="display:none; max-width:200px; margin-top:10px;">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Incidencia</button>
        <a href="ver_incidencias.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php include('../public/Components/footer.php'); ?>
</body>
</html>
