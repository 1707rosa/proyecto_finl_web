<?php
session_start();

// Verificación de sesión comentada para pruebas
// if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'reportero') {
//     header("Location: ../login.php");
//     exit();
// }

include("../config/db.php");

// Validar campos
if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['provincia'], $_POST['municipio'], $_POST['tipo'], $_POST['fecha'])) {
    
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $provincia = $conn->real_escape_string($_POST['provincia']);
    $municipio = $conn->real_escape_string($_POST['municipio']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $usuario_id = 1; // Usuario de prueba

    // Manejo de la foto
    $foto_ruta = NULL;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $directorio = "../uploads/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $foto_nombre = time() . "_" . basename($_FILES['foto']['name']);
        $foto_ruta = $directorio . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_ruta);
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO incidencias (titulo, descripcion, provincia, municipio, tipo, fecha, foto, usuario_id) 
            VALUES ('$titulo', '$descripcion', '$provincia', '$municipio', '$tipo', '$fecha', 
            " . ($foto_ruta ? "'$foto_ruta'" : "NULL") . ", $usuario_id)";

    echo "<div class='container'>";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>✅ Incidencia registrada correctamente.</p>";
        echo "<a href='registro_incidencia.php' class='btn'>Registrar otra</a>";
    } else {
        echo "<p class='error'>❌ Error al registrar incidencia: " . $conn->error . "</p>";
        echo "<a href='registro_incidencia.php' class='btn'>Volver</a>";
    }

    echo "</div>";

} else {
    echo "<div class='container'>";
    echo "<p class='error'>❌ Todos los campos obligatorios deben ser completados.</p>";
    echo "<a href='registro_incidencia.php' class='btn'>Volver</a>";
    echo "</div>";
}
?>
