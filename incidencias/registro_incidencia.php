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
    <link rel="stylesheet" href="../css/styles.css"> <!-- Asegúrate que el nombre sea correcto -->
</head>
<body>
    <div class="container">
        <h2>Registrar Incidencia</h2>

        <!-- Mensajes de éxito o error -->
        <?php
        if(isset($_SESSION['mensaje'])) {
            echo "<div class='success'>".$_SESSION['mensaje']."</div>";
            unset($_SESSION['mensaje']);
        }
        if(isset($_SESSION['error'])) {
            echo "<div class='error'>".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="procesar_incidencia.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="required">Título</label>
                <input type="text" name="titulo" placeholder="Ej: Accidente en autopista" required>
            </div>

            <div class="form-group">
                <label class="required">Descripción</label>
                <textarea name="descripcion" placeholder="Describe lo ocurrido..." required></textarea>
            </div>

            <div class="form-group">
                <label class="required">Provincia</label>
                <input type="text" name="provincia" placeholder="Ej: Santo Domingo" required>
            </div>

            <div class="form-group">
                <label class="required">Municipio</label>
                <input type="text" name="municipio" placeholder="Ej: Distrito Nacional" required>
            </div>

            <div class="form-group">
                <label class="required">Tipo de incidencia</label>
                <select id="tipoSelect" onchange="checkTipo(this)">
                    <option value="">-- Selecciona --</option>
                    <option value="Accidente">Accidente</option>
                    <option value="Desastre Natural">Desastre Natural</option>
                    <option value="Otro">Otro</option>
                    <option value="personalizado">Otro (escribe)</option>
                </select>
                <input type="text" name="tipo" id="tipoInput" placeholder="Escribe tu tipo..." style="display:none;">
            </div>

            <div class="form-group">
                <label class="required">Fecha</label>
                <input type="date" name="fecha" required>
            </div>

            <div class="form-group">
                <label>Foto (opcional)</label>
                <input type="file" name="foto" accept="image/*" onchange="previewImage(event)">
                <img id="preview" src="#" alt="Vista previa" style="display:none; max-width:200px; margin-top:10px;">
            </div>

            <button type="submit">Registrar Incidencia</button>
        </form>
    </div>

    <script>
        function previewImage(event){
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function checkTipo(select) {
            const input = document.getElementById('tipoInput');
            if(select.value === "personalizado") {
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
</body>
</html>
