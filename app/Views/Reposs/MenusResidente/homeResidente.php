<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!-- obtiene el contenido de la plantilla de la ruta especificada -->
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <?= $this->section('contenido') ?>
                        <!-- Mensajes de error -->
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('message') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <!--Contenido principal -->
                        <div class="container-xl px-4">
                            <h4 class="mb-0 mt-5">Categorias Principales: Primeros Pasos</h4>
                            <hr class="mt-2 mb-4" />
                            <!-- Knowledge base main category card 1-->
                            <a class="card card-icon lift lift-sm mb-4" href="<?= base_url('usuario/residentes/documentos') ?>">
                                <div class="row g-0">
                                    <div class="col-auto card-icon-aside bg-primary"><i class="text-white-50" data-feather="file"></i></div>
                                    <div class="col">
                                        <div class="card-body py-4">
                                            <h5 class="card-title text-primary mb-2">Subir Documentos</h5>
                                            <p class="card-text mb-1">Sube tus documentos para continuar con el proceso de residencias profesionales.</p>
                                            <div class="small text-muted">2 formularios relacionados.</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Knowledge base main category card 2-->
                            <a class="card card-icon lift lift-sm mb-4" href="<?= base_url('usuario/residentes/datos') ?>">
                                <div class="row g-0">
                                    <div class="col-auto card-icon-aside bg-secondary"><i class="text-white-50" data-feather="user"></i></div>
                                    <div class="col">
                                        <div class="card-body py-4">
                                            <h5 class="card-title text-secondary mb-2">Actualizar Información</h5>
                                            <p class="card-text mb-1">Ingresa los datos solicitados en los formularios para actualizar tu información de residencias profesionales.</p>
                                            <div class="small text-muted">2 formularios relacionados.</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Knowledge base main category card 3-->
                            <a class="card card-icon lift lift-sm mb-4" href="<?= base_url('usuario/residentes/empresa') ?>">
                                <div class="row g-0">
                                    <div class="col-auto card-icon-aside bg-teal"><i class="text-white-50" data-feather="grid"></i></div>
                                    <div class="col">
                                        <div class="card-body py-4">
                                            <h5 class="card-title text-teal mb-2">Datos de la Empresa</h5>
                                            <p class="card-text mb-1">Completa los datos solicitados para agregar una nueva empresa.</p>
                                            <div class="small text-muted">3 formularios relacionados.</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Knowledge base main category card 3-->
                            <a class="card card-icon lift lift-sm mb-4" href="<?= base_url('usuario/residentes/proyecto') ?>">
                                <div class="row g-0">
                                    <div class="col-auto card-icon-aside " style="background-color: rgba(254, 152, 0, 0.88);"><i class="text-white-50" data-feather="briefcase"></i></div>
                                    <div class="col">
                                        <div class="card-body py-4">
                                            <h5 class="card-title mb-2" style="color:rgba(254, 152, 0, 0.88);">Datos del Proyecto</h5>
                                            <p class="card-text mb-1">Completa los datos solicitados para agregar un nuevo proyecto.</p>
                                            <div class="small text-muted">3 formularios relacionados.</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <h4 class="mb-0 mt-5">Otras Categorias</h4>
                            <hr class="mt-2 mb-4" />
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <!-- Knowledge base category card 1-->
                                    <a class="card lift lift-sm h-100" href="<?= base_url('usuario/') ?>">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary mb-2">
                                                <i class="me-2" data-feather="edit-2"></i>
                                                Formatos
                                            </h5>
                                            <p class="card-text mb-1">Formatos disponibles para el proceso de residencias profesionales.</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="small text-muted">3 Archivos disponibles.</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <!-- Knowledge base category card 2-->
                                    <a class="card lift lift-sm h-100" href="<?= base_url('usuario/') ?>">
                                        <div class="card-body">
                                            <h5 class="card-title text-yellow mb-2">
                                                <i class="me-2" data-feather="credit-card"></i>
                                                Requisitos
                                            </h5>
                                            <p class="card-text mb-1">Conoce los requisitos para realizar el proceso de residencia profesional.</p> 
                                        </div>
                                        <div class="card-footer">
                                            <div class="small text-muted">2 articles in this category</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <!-- Knowledge base category card 3-->
                                    <a class="card lift lift-sm h-100" href="<?= base_url('usuario/') ?>">
                                        <div class="card-body">
                                            <h5 class="card-title text-teal mb-2">
                                                <i class="me-2" data-feather="code"></i>
                                                Departamento Residencias Profesionales y Servicio Social.
                                            </h5>
                                            <p class="card-text mb-1">Horarios e información de contacto.</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="small text-muted">1 articulo relacionado.</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>