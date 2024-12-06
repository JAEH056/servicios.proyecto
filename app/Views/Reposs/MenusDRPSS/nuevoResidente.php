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
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="<?=base_url('usuario/drpss/nuevo')?>">Residente</a>
            <a class="nav-link" href="<?=base_url('usuario/drpss/empresa')?>">Empresa</a>
            <a class="nav-link" href="<?=base_url('usuario/drpss/asesor')?>">Asesor Interno</a>
            <a class="nav-link" href="<?=base_url('usuario/drpss/proyecto')?>">Proyecto</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Nuevo Residente</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="numero_control">Número de control</label>
                                    <input class="form-control" id="numero_control" type="text" placeholder="Ingresa el numero de control" value="" />
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="nombre">Nombre(s)</label>
                                    <input class="form-control" id="nombre" type="text" placeholder="Ingresa el nombre(s)" value="" />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                    <input class="form-control" id="apellido1" type="text" placeholder="Ingresa el primer apellido" value="" />
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                    <input class="form-control" id="apellido2" type="text" placeholder="Ingresa el Segundo Apellido" value="" />
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="correo">Correo Personal</label>
                                <input class="form-control" id="correo" type="email" placeholder="Ingresa el correo personal" value="" />
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="button">Crear Residente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>