<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core) -->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Menú Principal sin "Opciones" -->
            <a class="nav-link" href="/laboratorio">
                <div class="nav-link-icon"><i class="fa-regular fa-building fa-lg"></i></div>
                Laboratorios
            </a>
            <a class="nav-link" href="/semestre/mostrar">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar-days"></i></div>
                Semestres
            </a>
            <a class="nav-link" href="/diasinhabiles">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
                Días inhábiles
            </a>
            <a class="nav-link" href="/laboratorista">
                <div class="nav-link-icon"><i class="fa-regular fa-clipboard fa-lg"></i></div>
                Gestión de horarios
            </a>
            <a class="nav-link" href="<?= base_url('horario') ?>">
                <div class="nav-link-icon"><i class="fa-regular fa-calendar"></i></div>
                Solicitar horarios
            </a>
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
