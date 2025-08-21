<?php
session_start();

// Verificar login
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

// Verificar roles
function verificar_roles($roles_permitidos = []) {
    if (!in_array($_SESSION['rol'], $roles_permitidos)) {
        die("No tienes permisos para acceder a esta página");
    }
}
?>
