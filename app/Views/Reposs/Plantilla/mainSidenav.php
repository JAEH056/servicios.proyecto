<nav class="sidenav shadow-right sidenav-dark">
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
            <div class="sidenav-menu-heading">Informacion General</div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDocs" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="file"></i></div>
                Documentacion
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDocs" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?= base_url('usuario/residentes/documentos') ?>">Subir documentos</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Residente)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Informacion Personal
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePersonal" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?= base_url('/usuario/residentes/datos') ?>">Mis Datos</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Empresa)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmpress" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                Empresa
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseEmpress" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?=base_url('usuario/residentes/empresa')?>">Informacion de Empresa</a>
                    <a class="nav-link" href="<?=base_url('usuario/residentes/empresa_asesor_externo')?>">Asesor Externo</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Proyectos)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProject" aria-expanded="false" aria-controls="collapseApps">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Proyecto
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseProject" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?=base_url('usuario/residentes/proyecto')?>">Informacion del Proyecto</a>
                    <a class="nav-link" href="<?=base_url('usuario/residentes/asesor_interno')?>">Asesor Interno</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Proyectos)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseReport" aria-expanded="false" aria-controls="collapseApps">
                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                Reportes
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseReport" data-bs-parent="#accordionSidenav">
            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                    <!-- Nested Sidenav Accordion (Pages -> Account)-->
                    <a class="nav-link" href="<?=base_url('usuario/residentes/reportes')?>">Reporte Parcial</a>
                    <a class="nav-link" href="<?=base_url('usuario/residentes/reportes')?>">Reporte Final</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Formatos)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                <div class="nav-link-icon"><i data-feather="folder"></i></div>
                Formatos y Requisitos
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="<?=base_url('')?>">Formatos Disponibles</a>
                    <a class="nav-link" href="<?=base_url('')?>">Requisitos RP</a>
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