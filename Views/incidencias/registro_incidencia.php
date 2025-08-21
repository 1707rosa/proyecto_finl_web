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
<<<<<<< HEAD
<<<<<<< HEAD:Views/incidencias/registro_incidencia.php
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/styles.css"> <!-- Asegúrate que el nombre sea correcto -->
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/registro_incidencia.php
=======
<<<<<<<< HEAD:incidencias/registro_incidencia.php
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
========
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/styles.css"> <!-- Asegúrate que el nombre sea correcto -->
>>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb:Views/incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
</head>
<body>
<?php include('../public/Components/navbar.php'); ?>

<<<<<<< HEAD
<<<<<<< HEAD:Views/incidencias/registro_incidencia.php
=======
<<<<<<<< HEAD:incidencias/registro_incidencia.php
<div class="container mt-3">
    <h2 class="text-primary">Registrar Incidencia</h2>

    <form action="procesar_incidencia.php" method="POST" enctype="multipart/form-data">
========
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
    <?php include('../../public/Components/navbar.php'); //navbar 
    ?>

    <div class="container home">
        <h2 class="text-primary">Registrar Incidencia</h2>
<<<<<<< HEAD
=======
<div class="container mt-3">
    <h2 class="text-primary">Registrar Incidencia</h2>

    <form action="procesar_incidencia.php" method="POST" enctype="multipart/form-data">
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/registro_incidencia.php
=======
>>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb:Views/incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb

        <div class="form-group mb-2">
            <label class="required">Título</label>
            <input type="text" name="titulo" class="form-control" placeholder="Ej: Accidente en autopista" required>
        </div>

<<<<<<< HEAD
<<<<<<< HEAD:Views/incidencias/registro_incidencia.php
        <form action="./procesar_incidencia.php" method="POST" enctype="multipart/form-data">
=======
=======
<<<<<<<< HEAD:incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
        <div class="form-group mb-2">
            <label class="required">Descripción</label>
            <textarea name="descripcion" class="form-control" placeholder="Describe lo ocurrido..." required></textarea>
        </div>
<<<<<<< HEAD
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/registro_incidencia.php
=======
========
        <form action="./procesar_incidencia.php" method="POST" enctype="multipart/form-data">
>>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb:Views/incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb

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

<<<<<<< HEAD
<<<<<<< HEAD:Views/incidencias/registro_incidencia.php
=======
<<<<<<<< HEAD:incidencias/registro_incidencia.php
        <div class="form-group mb-2">
            <label class="required">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
========
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
            <div class="form-group">
                <label class="required">Tipo de incidencia</label>
                <select id="tipoSelect" onchange="checkTipo(this)" class="form-control">
                    <option value="">-- Selecciona --</option>
                    <option value="Accidente">Accidente</option>
                    <option value="Desastre Natural">Desastre Natural</option>
                    <option value="Otro">Otro</option>
                    <option value="personalizado">Otro (escribe)</option>
                </select>
                <input type="text" name="tipo" id="tipoInput" placeholder="Escribe tu tipo..." class="form-control">
            </div>
<<<<<<< HEAD
=======
        <div class="form-group mb-2">
            <label class="required">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/registro_incidencia.php
=======
>>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb:Views/incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb

        <div class="form-group mb-2">
            <label>Foto (opcional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
            <img id="preview" src="#" alt="Vista previa" style="display:none; max-width:200px; margin-top:10px;">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Incidencia</button>
        <a href="ver_incidencias.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>

<<<<<<< HEAD
<<<<<<< HEAD:Views/incidencias/registro_incidencia.php
=======
<<<<<<<< HEAD:incidencias/registro_incidencia.php
========
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
            <div>
                <button type="submit" class="btn btn-primary">Registrar Incidencia</button>
                <a class="btn btn-danger" href="./ver_incidencias.php">Cancelar</a>
            </div>
        </form>
    </div>
    <?php include('../../public/Components/footer.php'); //footer 
    ?>

</body>
<<<<<<< HEAD
=======
>>>>>>> 97fd42e (Mis cambios en incidencias):incidencias/registro_incidencia.php
=======
>>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb:Views/incidencias/registro_incidencia.php
>>>>>>> bb4e7254fb2573e34ff570c3c5215f43c3a898cb
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<?php include('../public/Components/footer.php'); ?>
</body>
</html>
