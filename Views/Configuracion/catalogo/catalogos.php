<?php
session_start();
require '../../../config/db.php';

// Solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../../../config/modules/auth/login.php");
    exit();
}

// Traer catálogos
$provincias = $conn->query("SELECT * FROM provincias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$municipios = $conn->query("SELECT * FROM municipios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$tipos = $conn->query("SELECT * FROM tipos_incidencias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrar Catálogos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/styles.css">
</head>

<body>

    <?php include('../../../public/Components/navbar.php'); //navbar 
    ?>
    <h1>Panel de Catálogos</h1>
    <nav>
        <ul>
            <li><a href="../../Mapa/mapa.php">Inicio</a></li>
            <li><a href="../../../validar.php">Validar Reportes</a></li>
        </ul>
    </nav>

    <section style="padding:20px;">
        <h2>📌 Provincias</h2>
        <form method="post" action="./catalogos_update.php">
            <input type="text" name="nombre" placeholder="Nueva provincia" required>
            <input type="hidden" name="tipo" value="provincia">
            <button type="submit">Agregar</button>
        </form>
        <ul>
            <?php foreach ($provincias as $p): ?>
                <li><?= htmlspecialchars($p['nombre']) ?>
                    <a href="./catalogos_update.php?delete=provincia&id=<?= $p['id'] ?>" style="color:red;">[Eliminar]</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>📌 Municipios</h2>
        <form method="post" action="./catalogos_update.php">
            <input type="text" name="nombre" placeholder="Nuevo municipio" required>
            <input type="hidden" name="tipo" value="municipio">
            <button type="submit">Agregar</button>
        </form>
        <ul>
            <?php foreach ($municipios as $m): ?>
                <li><?= htmlspecialchars($m['nombre']) ?>
                    <a href="php/catalogos_update.php?delete=municipio&id=<?= $m['id'] ?>" style="color:red;">[Eliminar]</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>📌 Tipos de Incidencias</h2>
        <form method="post" action="./catalogos_update.php">
            <input type="text" name="nombre" placeholder="Nuevo tipo" required>
            <input type="hidden" name="tipo" value="tipo">
            <button type="submit">Agregar</button>
        </form>
        <ul>
            <?php foreach ($tipos as $t): ?>
                <li><?= htmlspecialchars($t['nombre']) ?>
                    <a href="./catalogos_update.php?delete=tipo&id=<?= $t['id'] ?>" style="color:red;">[Eliminar]</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php include('../../../public/Components/footer.php'); //navbar 
    ?>
</body>

</html>