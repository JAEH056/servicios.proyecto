<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('Reposs/MenusDRPSS/inicioDRPSS'); ?>

<?= $this->section('contenido'); ?>
<main>
    <?= $this->include('Reposs/Plantilla/mainHeaderDRPSS'); ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="container-xl px-4 mt-4">
                <!-- Account page navigation-->
                <nav class="nav nav-borders">
                    <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/nuevo') ?>">Residente</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/empresa') ?>">Empresa</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/asesor') ?>">Asesor Interno</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/proyecto') ?>">Proyecto</a>
                </nav>
                <hr class="mt-0 mb-4" />
                <div class="row">
                    <div class="col-xl-8">
                        <!-- Envia la lista de errores al formulario -->
                        <?php if (session()->getFlashdata('error') !== null) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php } ?>
                        <?php if (session()->getFlashdata('message') !== null) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashdata('message'); ?>
                            </div>
                        <?php } ?>
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Nuevo Residente</div>
                            <div class="card-body">
                                <form action="<?= base_url('usuario/drpss/nuevo') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (username)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="numero_control">Número de control</label>
                                            <input class="form-control" id="numero_control" name="numero_control" 
                                            type="text" pattern="^[a-z0-9]+$" title="El número de control debe contener solo letras minúsculas y números enteros." placeholder="Ingresa el numero de control" value="<?= set_value('numero_control'); ?>"/>
                                        </div>
                                        <!-- Menu seleccion programa educatvo -->
                                        <div class="mb-3">
                                            <label class="small mb-1" name="idprograma_educativo" for="idprograma_educativo">Programa Educativo</label>
                                            <select class="form-control" id="idprograma_educativo" name="idprograma_educativo">
                                                <?php foreach ($programa as $pe): ?>
                                                    <option value="<?= $pe['idprograma_educativo'] ?>"><?= $pe['nombre_programa_educativo'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Ingresa el nombre(s)" value="<?= set_value('nombre'); ?>" />
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" name="apellido1" type="text" placeholder="Ingresa el primer apellido" value="<?= set_value('apellido1'); ?>" />
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" name="apellido2" type="text" placeholder="Ingresa el Segundo Apellido" value="<?= set_value('apellido2'); ?>" />
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Crear Residente</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>