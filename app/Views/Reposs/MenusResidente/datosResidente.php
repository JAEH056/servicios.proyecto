<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!-- obtiene el contenido de la plantilla de la ruta especificada -->
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>

<?= $this->section('contenido') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Actualizar Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="#example" data-bs-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Estado de entrega</a>
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
                            <h5 class="card-title mb-4">Verifica y actualiza tu informacion.</h5>
                            <p>Ingresa los datos solicitados, esta informacion sera usada posteriormente para los formatos necesarios en el proceso de residencias profesionales.</p>
                                <form action="<?= base_url('usuario/residentes/datos'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (username)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="numControl">Numero de control</label>
                                            <input class="form-control" id="numControl" type="text"
                                                placeholder="numero de control" name="numero_control"
                                                value="<?= esc($datosResidente['numero_control']); ?>" />
                                        </div>
                                        <!-- Form Group (nombre)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" type="text"
                                                placeholder="Ingresa tu nombre" name="nombre"
                                                value="<?= esc($datosResidente['nombre']); ?>" />
                                        </div>
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text"
                                                placeholder="Ingresa tu primer apellido" name="apellido1"
                                                value="<?= esc($datosResidente['apellido1']); ?>" />
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text"
                                                placeholder="Ingresa tu segundo apellido" name="apellido2"
                                                value="<?= esc($datosResidente['apellido2']); ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (celular)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="celular">Celular</label>
                                            <input class="form-control" id="celular" type="text"
                                                placeholder="Ingresa tu celular" name="celular"
                                                value="<?= esc($datosResidente['celular']); ?>" />
                                        </div>
                                        <!-- Form Group (telefono)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="telefono">Telefono (opcional)</label>
                                            <input class="form-control" id="telefono" type="text"
                                                placeholder="Ingresa tu telefono" name="telefono"
                                                value="<?= esc($datosResidente['telefono']); ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Ciudad)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="ciudad">Ciudad</label>
                                            <input class="form-control" id="ciudad" type="text"
                                                placeholder="Ingresa tu ciudad" name="ciudad"
                                                value="<?= esc($datosResidente['ciudad']); ?>" />
                                        </div>
                                        <!-- Form Group (Domicilio)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="domicilio">Domicilio</label>
                                            <input class="form-control" id="domicilio" type="text"
                                                placeholder="Ingresa tu domicilio" name="domicilio"
                                                value="<?= esc($datosResidente['domicilio']); ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Menu seleccion seguro (afiliacion, imms, isste, etc) -->
                                        <div class="col-md-6">
                                            <label class="small mb-1" name="seguroSocial" for="seguroSocial">Seguro
                                                Social</label>
                                            <select class="form-control" id="seguroSocial" name="seguro_social">
                                                <option value="<?= esc($datosResidente['seguro_social']); ?>" selected></option>
                                                <option>IMSS</option>
                                                <option>ISSSTE</option>
                                                <option>Otros</option>
                                            </select>
                                        </div>
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="numeroSS">Numero Seguro social</label>
                                            <input class="form-control" id="numeroSS" type="text" name="numero_ss"
                                                placeholder="Ingresa numero de seguro social"
                                                value="<?= esc($datosResidente['numero_ss']); ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Menu seleccion programa educatvo -->
                                        <div class="mb-3">
                                            <label class="small mb-1" name="idprograma_educativo" for="idprograma_educativo">Programa Educativo</label>
                                            <select class="form-control" id="idprograma_educativo" name="idprograma_educativo">
                                                <?php if(isset($datosResidente['idprograma_educativo'])):?>
                                                <option value="<?= esc($datosResidente['idprograma_educativo']); ?>" selected ><?= esc($datosResidente['nombre_programa']); ?></option>
                                                <?php endif;?>
                                                <?php foreach ($programa as $pe): ?>
                                                    <option value="<?= $pe['idprograma_educativo'] ?>"><?= $pe['nombre_programa_educativo'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Actualizar informacion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="example" role="tabpanel" aria-labelledby="example-tab">
                        <h5 class="card-title">Subir Documentos</h5>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nombre)-->
                            <div class="mb-3">
                                <!-- Informacion extra  -->
                            </div>
                            <!-- Form Group (first name)-->
                            <label for="file">Elegir archivo (Solo se permite PDF)</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Subir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>