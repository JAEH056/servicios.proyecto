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
            <a class="nav-link" href="<?= base_url('usuario/drpss/nuevo') ?>">Residente</a>
            <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/empresa') ?>">Empresa</a>
            <a class="nav-link" href="<?= base_url('usuario/drpss/asesor') ?>">Asesor Interno</a>
            <a class="nav-link" href="<?= base_url('usuario/drpss/proyecto') ?>">Proyecto</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Nueva Empresa</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="nombre_empresa">Nombre de empresa</label>
                                    <input class="form-control" id="nombre_empresa" type="text" placeholder="Ingresa el nombre de la empresa" value="" />
                                </div>
                                <!-- Form Group (first name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="mision">Mision</label>
                                    <input class="form-control" id="mision" type="text" placeholder="Mision de la empresa" value="" />
                                </div>
                                <!-- Form Group (first name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="RFC">RFC Empresa</label>
                                    <input class="form-control" id="RFC" type="text" placeholder="RFC de la empresa" value="" />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (last name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="puesto_titular">Puesto Titular</label>
                                    <input class="form-control" id="puesto_titular" type="text" placeholder="Ingresa el puesto de Titular" value="" />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="nombre_titular">Grado Academico</label>
                                    <input class="form-control" id="nombre_titular" type="text" placeholder="Lic.,Ma., Dr., etc." value="" />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col md-6">
                                    <label class="small mb-1" for="nombre_titular">Nombre(s) de Titular</label>
                                    <input class="form-control" id="nombre_titular" type="text" placeholder="Ingresa el nombre de Titular" value="" />
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="apellido1_titular">Primer Apellido</label>
                                    <input class="form-control" id="apellido1_titular" type="text" placeholder="Ingresa el Primer Apellido" value="" />
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="apellido2_titular">Segundo Apellido</label>
                                    <input class="form-control" id="apellido2_titular" type="text" placeholder="Ingresa el Segundo Apellido" value="" />
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="md-3">
                                    <label class="small mb-1" for="colonia">Colonia</label>
                                    <input class="form-control" id="colonia" type="text" placeholder="Colonia de la empresa" value="" />
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col md-3">
                                    <label class="small mb-1" for="ciudad">Ciudad</label>
                                    <input class="form-control" id="ciudad" type="text" placeholder="Ciudad de la empresa" value="" />
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="codigo_postal">Codigo Postal</label>
                                    <input class="form-control" id="codigo_postal" type="text" placeholder="CP Empresa" value="" />
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (email address)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="telefono">Telefono Empresa</label>
                                    <input class="form-control" id="telefono" type="text" placeholder="Ingresa el telefono de la empresa" value="" />
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="celular">Celular Empresa</label>
                                    <input class="form-control" id="celular" type="text" placeholder="Ingresa el celular de la empresa" value="" />
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="correo">Correo Empresa</label>
                                    <input class="form-control" id="correo" type="email" placeholder="Ingresa el correo de la empresa" value="" />
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="button">Agregar Empresa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>