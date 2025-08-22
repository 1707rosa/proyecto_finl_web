<?php
// Detecta si es http o https
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Dominio
$host = $_SERVER['HTTP_HOST'];

// Carpeta raíz del proyecto (ajusta si tu proyecto tiene otro nombre de carpeta)
$projectFolder = '/proyecto_finl_web';

// Base URL lista para usarse
$base_url = $protocolo . $host . $projectFolder;
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black mb-2 p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $base_url ?>/Views/Mapa/mapa.php">SIR - Reporte de Incidencias</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= $base_url ?>/Views/Mapa/mapa.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Views/Mapa/mapa.php">Catalogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Views/super/dashboard.php">Super</a>
                </li>

                <!-- Dropdown Configuración -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Configuración
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?= $base_url ?>/?vista=Perfil">Perfil</a>
                        </li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/Views/Configuracion/Incidencias/lista_incidencias.php">Listado de Incidencias</a></li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/Views/Configuracion/Incidencias/lista_incidencias.php">Catalogo</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= $base_url ?>/config/modules/auth/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>