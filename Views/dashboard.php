<?php
include('../config/modules/auth/check_out.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Dashboard</title>
</head>

<body>

    <?php include('../public/Components/navbar.php'); //navbar 
    ?>
    <div class="home container-fluid ">

        <h1>Dashboard</h1>
        <p>Bienvenido, <?php echo $_SESSION['nombre']; ?> (Rol: <?php echo $_SESSION['rol']; ?>)</p>

        <?php if ($_SESSION['rol'] == 'reportero'): ?>
            <h2>Sección de reportero</h2>
            <p>Aquí podrás crear incidencias (cuando el módulo esté listo)</p>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] == 'validador'): ?>
            <h2>Sección de validador</h2>
            <p>Aquí podrás aprobar o editar incidencias</p>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] == 'admin'): ?>
            <h2>Sección de administrador</h2>
            <p>Aquí podrás administrar usuarios y roles</p>
        <?php endif; ?>
    </div>
    <?php include('../public/Components/footer.php'); //navbar 
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>