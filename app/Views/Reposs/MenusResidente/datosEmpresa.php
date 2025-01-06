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
                        <a class="nav-link active" id="overview-tab" href="#datosempresa" data-bs-toggle="tab" role="tab" aria-controls="datosempresa" aria-selected="true">Datos de Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="overview-tab" href="#agregarempresa" data-bs-toggle="tab" role="tab" aria-controls="agregarempresa" aria-selected="false">Agregar Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="#asesorexterno" data-bs-toggle="tab" role="tab" aria-controls="asesorexterno" aria-selected="false">Asesor Externo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#carta" data-bs-toggle="tab" role="tab" aria-controls="carta" aria-selected="false">Descargar Carta</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="datosempresa" role="tabpanel" aria-labelledby="datosempresa-tab">
                        <div class="row justify-content-center">
                            <?php if (!isset($datosEmpresa)): ?>
                                <div class="col-xxl-6 col-xl-8">
                                    <h4>Datos de la Empresa</h4>
                                    <p>Agrega una nueva empresa para mostrar los datos en esta seccion.</p>
                                </div>
                            <?php else: ?>
                                <div class="col-xxl-6 col-xl-8">
                                    <h4 class="card-title mb-4">Datos de la empresa</h4>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Empresa:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['nombre_empresa']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Mision:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['mision']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Sector:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['Sector']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Ramo:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['Ramo']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>RFC:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['RFC']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Colonia:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['colonia']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Ciudad:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['ciudad']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Codigo Postal:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['codigo_postal']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Celular:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['celular']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Telefono:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['telefono']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Correo:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['correo']) ?></div>
                                    </div>
                                    <br>
                                    <h6 class="text-truncate"><em>Datos del Titular</em></h6>
                                    <hr class="my-4" />
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Puesto:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['puesto_titular']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Grado Academico:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['grado_titular']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Nombre:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['nombre_titular']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Primer Apellido:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['apellido1_titular']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Segundo Apellido:</em></div>
                                        <div class="col"><?= esc($datosEmpresa['apellido2_titular']) ?></div>
                                    </div>
                                    <br>
                                    <h6 class="text-truncate"><em>Datos del Asesor Externo</em></h6>
                                    <hr class="my-4" />
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Puesto:</em></div>
                                        <div class="col"><?= esc($asesorExterno['puesto']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Grado Academico:</em></div>
                                        <div class="col"><?= esc($asesorExterno['grado']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Nombre:</em></div>
                                        <div class="col"><?= esc($asesorExterno['nombre']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Primer Apellido:</em></div>
                                        <div class="col"><?= esc($asesorExterno['apellido1']) ?></div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Segundo Apellido:</em></div>
                                        <div class="col"><?= esc($asesorExterno['apellido2']) ?></div>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-light" type="button">Eliminar</button>
                                        <button class="btn btn-primary" type="button">Nueva Empresa</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="agregarempresa" role="tabpanel" aria-labelledby="agregarempresa-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <!-- Envia la lista de errores al formulario -->
                                <?php if (session()->getFlashdata('error') !== null): ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('mensaje') !== null): ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('mensaje'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Envia la lista de errores al formulario -->
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Ingresa toda la información solicitada</h4>
                                    <p>Ingresa los datos solicitados. Esta información se utilizará posteriormente para completar los formatos necesarios en el proceso de residencias profesionales.</p>
                                </div>
                                <form action="<?= base_url('usuario/residentes/empresa'); ?>" method="post">
                                    <?= csrf_field() ?>
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (username)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre_empresa">Nombre de la empresa</label>
                                            <input class="form-control" id="nombre_empresa" name="nombre_empresa" type="text" placeholder="Ingresa el nombre de la empresa" value="<?= esc($datosEmpresa['nombre_empresa']) ?>" />
                                        </div>
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="mision">Misión</label>
                                            <input class="form-control" id="mision" name="mision" type="text" placeholder="Mision de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="RFC">RFC de la Empresa</label>
                                            <input class="form-control" id="RFC" name="RFC" type="text" placeholder="RFC de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (Ramo de empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="ramo">Ramo</label>
                                            <select class="form-control" id="ramo" name="idramo">
                                                <?php if (isset($opcionRamo['idramo'])): ?>
                                                    <option value="<?= esc($opcionRamo['idramo']); ?>" selected><?= esc($opcionRamo['nombre']); ?></option>
                                                <?php else: ?>
                                                    <?php foreach ($opcionRamo as $row): ?>
                                                        <option value="<?= $row['idramo'] ?>"><?= $row['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <!-- Form Group (Sector de la empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="sector">Sector</label>
                                            <select class="form-control" id="sector" name="idsector">
                                                <?php if (isset($opcionSector['idsector'])): ?>
                                                    <option value="<?= esc($opcionSector['idsector']); ?>" selected><?= esc($opcionSector['nombre']); ?></option>
                                                <?php else: ?>
                                                    <?php foreach ($opcionSector as $row): ?>
                                                        <option value="<?= $row['idsector'] ?>"><?= $row['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (organization name)-->
                                        <div class="md-3">
                                            <label class="small mb-1" for="colonia">Colonia</label>
                                            <input class="form-control" id="colonia" name="colonia" type="text" placeholder="Colonia de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col md-3">
                                            <label class="small mb-1" for="ciudad">Ciudad</label>
                                            <input class="form-control" id="ciudad" name="ciudad" type="text" placeholder="Ciudad de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col-md-3">
                                            <label class="small mb-1" for="codigo_postal">Código Postal</label>
                                            <input class="form-control" id="codigo_postal" name="codigo_postal" type="text" placeholder="CP Empresa" value="" />
                                        </div>
                                    </div>
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (telefono empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="telefono">Teléfono Empresa</label>
                                            <input class="form-control" id="telefono" name="telefono" type="text" placeholder="Ingresa el telefono de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (celular empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="celular">Celular Empresa</label>
                                            <input class="form-control" id="celular" name="celular" type="text" placeholder="Ingresa el celular de la empresa" value="" />
                                        </div>
                                        <!-- Form Group (email empresa)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="correo">Correo Empresa</label>
                                            <input class="form-control" id="correo" name="correo" type="email" placeholder="Ingresa el correo de la empresa" value="" />
                                        </div>
                                    </div>
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <h6>Datos del Titular de la Empresa</h6>
                                        <hr class="my-4" />
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (last name)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="puesto_titular">Puesto</label>
                                                <input class="form-control" id="puesto_titular" name="puesto_titular" type="text" placeholder="Ingresa el puesto del Titular" value="" />
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col-md-3">
                                                <label class="small mb-1" for="grado_titular">Grado Académico</label>
                                                <input class="form-control" id="grado_titular" name="grado_titular" type="text" placeholder="Lic.,Ma., Dr., etc." value="" />
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col md-6">
                                                <label class="small mb-1" for="nombre_titular">Nombre(s)</label>
                                                <input class="form-control" id="nombre_titular" name="nombre_titular" type="text" placeholder="Ingresa el nombre de Titular" value="" />
                                            </div>
                                        </div>
                                        <!-- Form Row        -->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (organization name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="apellido1_titular">Primer Apellido</label>
                                                <input class="form-control" id="apellido1_titular" name="apellido1_titular" type="text" placeholder="Ingresa el Primer Apellido" value="" />
                                            </div>
                                            <!-- Form Group (organization name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="apellido2_titular">Segundo Apellido</label>
                                                <input class="form-control" id="apellido2_titular" name="apellido2_titular" type="text" placeholder="Ingresa el Segundo Apellido" value="" />
                                            </div>
                                        </div>
                                        <hr class="my-4" />
                                        <!-- Form Group (Asesor Externo)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="asesor_externo">Asesor Externo</label>
                                            <?php if (empty($asesorExterno['idasesor_externo']) == true): ?>
                                                <label class="form-control">Agrega un Asesor para mostrar sus datos.</label>
                                            <?php else: ?>
                                                <select class="form-control" id="asesor_externo" name="idasesor_externo">

                                                    <option value="<?= $asesorExterno['idasesor_externo'] ?>"><?= $asesorExterno['puesto'] ?><?= $asesorExterno['grado'] ?><?= $asesorExterno['nombre'] ?><?= $asesorExterno['apellido1'] ?></option>

                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Agregar Empresa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="asesorexterno" role="tabpanel" aria-labelledby="asesorexterno-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <!-- Envia la lista de errores al formulario -->
                                <?php if (session()->getFlashdata('error') !== null): ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('mensaje') !== null): ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('mensaje'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Envia la lista de errores al formulario -->
                                <h5 class="card-title">Datos de Asesor Externo</h5>
                                <p>Ingresa los datos solicitados. Esta información se utilizará posteriormente para completar los formatos necesarios en el proceso de residencias profesionales.</p>
                                <form action="<?= base_url('usuario/residentes/asesor-externo') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="puesto">Puesto</label>
                                            <input class="form-control" id="puesto" type="text"
                                                placeholder="Puesto del asesor" name="puesto"
                                                value="<?= esc($asesorExterno['puesto']) ?>" />
                                        </div>
                                        <!-- Form Group (Grado Academico)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="grado">Grado Academico</label>
                                            <input class="form-control" id="grado" type="text"
                                                placeholder="Grado academico ej.: Lic. ISC. MA. etc." name="grado"
                                                value="<?= esc($asesorExterno['grado']) ?>" />
                                        </div>
                                        <!-- Form Group (Nombre Titular)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" type="text"
                                                placeholder="Ingresa el nombre(s) del asesor" name="nombre"
                                                value="<?= esc($asesorExterno['nombre']) ?>" />
                                        </div>
                                        <!-- Form Group (Primer Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text"
                                                placeholder="Ingresa el primer apellido" name="apellido1"
                                                value="<?= esc($asesorExterno['apellido1']) ?>" />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text"
                                                placeholder="Ingresa el segundo apellido" name="apellido2"
                                                value="<?= esc($asesorExterno['apellido2']) ?>" />
                                        </div>
                                        <!-- Form Group (email asesor)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="correo">Correo del asesor</label>
                                            <input class="form-control" id="correo" name="correo" type="email" placeholder="Ingresa el correo del asesor" value="<?= esc($asesorExterno['correo']) ?>" />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="telefono">Telefono Asesor</label>
                                            <input class="form-control" id="telefono" type="text"
                                                placeholder="Ingresa el telefono del asesor" name="telefono"
                                                value="<?= esc($asesorExterno['telefono']) ?>" />
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Agregar Asesor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="carta" role="tabpanel" aria-labelledby="carta-tab">
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
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a> y de la <a href="">empresa</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Formal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a>, de la <a href="">empresa</a> y agregar informacion del <a href="">Asesor Externo</a>.</td>
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