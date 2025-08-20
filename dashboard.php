<?php
include 'modules/auth/check_out.php';
?>
<h1>Dashboard</h1>
<p>Bienvenido, <?php echo $_SESSION['nombre']; ?> (Rol: <?php echo $_SESSION['rol']; ?>)</p>

<?php if($_SESSION['rol'] == 'reportero'): ?>
    <h2>Sección de reportero</h2>
    <p>Aquí podrás crear incidencias (cuando el módulo esté listo)</p>
<?php endif; ?>

<?php if($_SESSION['rol'] == 'validador'): ?>
    <h2>Sección de validador</h2>
    <p>Aquí podrás aprobar o editar incidencias</p>
<?php endif; ?>

<?php if($_SESSION['rol'] == 'admin'): ?>
    <h2>Sección de administrador</h2>
    <p>Aquí podrás administrar usuarios y roles</p>
<?php endif; ?>
