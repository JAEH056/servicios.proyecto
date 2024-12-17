<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>

<?= $this->section('contenido'); ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Datos de Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="#example" data-bs-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Asesor Externo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#download" data-bs-toggle="tab" role="tab" aria-controls="download" aria-selected="false">Descargar Carta</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <!-- Envia la lista de errores al formulario -->
                        <?php if (session()->getFlashdata('error') !== null || session()->getFlashdata('mensaje') !== null) { ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                                <?= session()->getFlashdata('mensaje'); ?>
                            </div>
                        <?php } ?>
                        <!-- Envia la lista de errores al formulario -->
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <h5 class="card-title mb-4">Agrega toda la información solicitada.</h5>
                                <p>Ingresa los datos solicitados. Esta información se utilizará posteriormente para completar los formatos necesarios en el proceso de residencias profesionales.</p>
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
                                            <label class="small mb-1" for="mision">Misión</label>
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
                                            <label class="small mb-1" for="nombre_titular">Grado Académico</label>
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
                                            <label class="small mb-1" for="codigo_postal">Código Postal</label>
                                            <input class="form-control" id="codigo_postal" type="text" placeholder="CP Empresa" value="" />
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (email address)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="telefono">Teléfono Empresa</label>
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
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="button">Agregar Empresa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="example" role="tabpanel" aria-labelledby="example-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <h5 class="card-title">Datos de Asesor Externo</h5>
                                <p>Ingresa los datos solicitados. Esta información se utilizará posteriormente para completar los formatos necesarios en el proceso de residencias profesionales.</p>
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
                    <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                        <h5 class="card-title">Resumen de Información.</h5>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nombre)-->
                            <div class="mb-3">
                                <!-- Informacion extra  -->
                            </div>
                            <table>
                                <thead>
                                    <th>Nombre del Formato</th>
                                    <th>Información requerida</th>
                                    <th>Acción</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Informal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos')?>">actualizar informacion personal</a> y de la <a href="">empresa</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Formal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos')?>">actualizar informacion personal</a>, de la <a href="">empresa</a> y agregar informacion del <a href="">Asesor Externo</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>