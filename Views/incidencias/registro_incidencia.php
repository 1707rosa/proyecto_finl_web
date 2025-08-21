<?php
session_start();

// Solo reporteros
// if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'reportero') {
//     header("Location: ../login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/styles.css"> <!-- Asegúrate que el nombre sea correcto -->
</head>

<body>

    <?php include('../../public/Components/navbar.php'); //navbar 
    ?>

    <div class="container home">
        <h2 class="text-primary">Registrar Incidencia</h2>

        <!-- Mensajes de éxito o error -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='success'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="./procesar_incidencia.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="required">Título</label>
                <input type="text" name="titulo" placeholder="Ej: Accidente en autopista" required class="form-control">
            </div>

            <div class="form-group">
                <label class="required">Descripción</label>
                <textarea name="descripcion" placeholder="Describe lo ocurrido..." required class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label class="required">Provincia</label>
                <input type="text" name="provincia" placeholder="Ej: Santo Domingo" required class="form-control">
            </div>

            <div class="form-group">
                <label class="required">Municipio</label>
                <input type="text" name="municipio" placeholder="Ej: Distrito Nacional" required class="form-control">
            </div>

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

            <div class="form-group">
                <label class="required">Fecha</label>
                <input type="date" name="fecha" required class="form-control">
            </div>

            <div class="form-group">
                <label>Foto (opcional)</label>
                <input type="file" name="foto" accept="image/*" onchange="previewImage(event)" class="form-control">
                <img id="preview" src="#" alt="Vista previa" style="display:none; max-width:200px; margin-top:10px;">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Registrar Incidencia</button>
                <a class="btn btn-danger" href="./ver_incidencias.php">Cancelar</a>
            </div>
        </form>
    </div>
    <?php include('../../public/Components/footer.php'); //footer 
    ?>

</body>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function checkTipo(select) {
        const input = document.getElementById('tipoInput');
        if (select.value === "personalizado") {
            input.style.display = "block";
            input.required = true;
            input.value = "";
        } else {
            input.style.display = "none";
            input.required = false;
            input.value = select.value;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>