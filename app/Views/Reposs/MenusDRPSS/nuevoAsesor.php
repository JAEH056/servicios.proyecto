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
                    <a class="nav-link" href="<?= base_url('usuario/drpss/nuevo') ?>">Residente</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/empresa') ?>">Empresa</a>
                    <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/asesor') ?>">Asesor Interno</a>
                    <a class="nav-link" href="<?= base_url('usuario/drpss/proyecto') ?>">Proyecto</a>
                </nav>
                <hr class="mt-0 mb-4" />
                <div class="row">
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Nuevo Asesor</div>
                            <div class="card-body">
                                <form>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="puesto">Puesto</label>
                                            <input class="form-control" id="puesto" type="text"
                                                placeholder="Puesto del asesor" name="puesto"
                                                value="<?php //set_value('puesto'); 
                                                        ?>" />
                                        </div>
                                        <!-- Form Group (Grado Academico)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="grado">Grado Academico</label>
                                            <input class="form-control" id="grado" type="text"
                                                placeholder="Grado academico ej.: Lic. ISC. MA. etc." name="grado"
                                                value="<?php // set_value('grado'); 
                                                        ?>" />
                                        </div>
                                        <!-- Form Group (Nombre Titular)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" type="text"
                                                placeholder="Ingresa el nombre(s) del asesor" name="nombre"
                                                value="<?php // set_value('nombre'); 
                                                        ?>" />
                                        </div>
                                        <!-- Form Group (Primer Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text"
                                                placeholder="Ingresa el primer apellido" name="apellido1"
                                                value="<?php // set_value('apellido1'); 
                                                        ?>" />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text"
                                                placeholder="Ingresa el segundo apellido" name="apellido2"
                                                value="<?php // set_value('apellido2'); 
                                                        ?>" />
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="button">Agregar Asesor</button>
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