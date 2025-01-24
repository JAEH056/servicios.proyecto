<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>
            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Residencias Profesionales</div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDocs" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="users"></i></div>
                Residentes
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDocs" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?= base_url('usuario/drpss/home') ?>">Revision de Documentos</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/residentes') ?>">Lista de Residentes</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/nuevo') ?>">Nuevo Residente</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/home') ?>">Liberaciones</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Proyectos
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePersonal" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?= base_url('usuario/drpss/lista-proyectos') ?>">Lista Proyectos</a>
                </nav>
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?= base_url('') ?>">Banco Proyectos</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmpress" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="users"></i></div>
                Asesores
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseEmpress" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?=base_url('usuario/drpss/asesor')?>">Lista de Asesores</a>
                    <a class="nav-link" href="<?=base_url('usuario/drpss/asesor')?>">Asesor Interno</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Applications)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProject" aria-expanded="false" aria-controls="collapseApps">
                <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                Empresa
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseProject" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?=base_url('usuario/drpss/lista-empresas')?>">Lista de Empresas</a>
                    <a class="nav-link" href="<?=base_url('usuario/drpss/lista-empresas')?>">Banco Empresas</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Flows)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                Formatos
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="usuario/drpss/lista-formatos">Lista de Formatos</a>
                    <a class="nav-link" href="usuario/drpss/documentos-drpss">Documentos Disponibles</a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Nombre de usuario:</div>
            <div class="sidenav-footer-title"><?= esc($user['displayName']); ?></div>
        </div>
    </div>
</nav>