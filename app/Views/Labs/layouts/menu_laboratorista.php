<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core) -->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Menú Principal sin "Opciones" -->
            <a class="nav-link" href="/usuario/mostrar/laboratorio">
                <div class="nav-link-icon"><i class="fa-regular fa-building fa-lg"></i></div>
                Laboratorios
            </a>
            <a class="nav-link" href="/usuario/mostrar/semestre">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar-days"></i></div>
                Semestres
            </a>
            <a class="nav-link" href="/usuario/diasinhabiles">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
                Días inhábiles
            </a>
            <a class="nav-link" href="/usuario/laboratorista">
                <div class="nav-link-icon"><i class="fa-regular fa-clipboard fa-lg"></i></div>
                Gestión de horarios
            </a>
            <a class="nav-link" href="<?= base_url('/usuario/horario') ?>">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar"></i></div>
                Solicitar horarios
            </a>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                <div class="nav-link-icon"><i class="fa-solid fa-table"></i></div>
                Gestión carreras
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="dashboard-3.html">Carrrera</a>
                    <a class="nav-link" href="dashboard-4.html">Especialidad</a>
                    <a class="nav-link" href="dashboard-2.html">Asignaturas</a>
                    <a class="nav-link" href="dashboard-2.html">Grupos</a>
                    <a class="nav-link" href="dashboard-1.html">Retícula</a>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Sidenav Footer -->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">Valerie Luna</div>
        </div>
    </div>
</nav>