<?php
session_start();

    // No logueado → Login
    header("Location: config/modules/auth/login.php");

exit;


// Si no hay usuario logueado → redirige al login
if (!isset($_SESSION['usuario'])) {
    header("Location: config/modules/auth/login.php");
    exit;
}

// Redirigir según rol
switch ($_SESSION['rol']) {
    case 'administrador':
        header("Location: config/modules/auth/login.php");
        break;

    case 'validador':
        // Usuarios con permisos para el panel Rosa
        header("Location: super/index.php");
        exit;
        break;

    case 'reportero':
        // Usuario normal, página principal de reportero
        header("Location: config/modules/home.php");
        exit;
        break;

    default:
        // Rol desconocido → logout por seguridad
        session_destroy();
        header("Location: config/modules/auth/login.php");
        exit;
}
?>

