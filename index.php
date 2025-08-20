<?php
session_start();

// Si no hay usuario logueado → redirige al login
if (!isset($_SESSION['usuario'])) {
    header("Location: modules/auth/login.php");
    exit;
}

// Redirigir según rol
switch ($_SESSION['rol']) {
    case 'administrador':
    case 'validador':
        // Usuarios con permisos para el panel Rosa
        header("Location: super/index.php");
        exit;

    case 'reportero':
        // Usuario normal, página principal de reportero
        header("Location: modules/home.php");
        exit;

    default:
        // Rol desconocido → logout por seguridad
        session_destroy();
        header("Location: modules/auth/login.php");
        exit;
}
?>
