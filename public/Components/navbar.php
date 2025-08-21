<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black mb-2 p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="../Views/dashboard.php">SIR - Reporte de Incidencias</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="../Views/dashboard.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="../Views/Mapa/mapa.php">Mapa de Incidencias</a></li>
                <li class="nav-item"><a class="nav-link" href="?vista=Acerca">Acerca</a></li>

                <!-- Dropdown Configuración -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Configuración
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="?vista=Perfil">Perfil</a></li>
                        <li>
                        <li><a class="dropdown-item" href="../incidencias/ver_incidencias.php">Listado de Incidencias</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../config/modules/auth/logout.php">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>