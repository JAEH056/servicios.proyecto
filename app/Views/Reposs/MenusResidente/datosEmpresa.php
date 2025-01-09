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
                        <a class="nav-link" id="overview-tab" href="#datosempresa" data-bs-toggle="tab" role="tab" aria-controls="datosempresa" aria-selected="false">Datos de Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" href="#agregarempresa" data-bs-toggle="tab" role="tab" aria-controls="agregarempresa" aria-selected="true">Agregar Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="<?= base_url('/usuario/residentes/empresa_asesor_externo')?>" aria-selected="false">Asesor Externo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#carta" data-bs-toggle="tab" role="tab" aria-controls="carta" aria-selected="false">Descargar Carta</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade" id="datosempresa" role="tabpanel" aria-labelledby="datosempresa-tab">
                        <?php if (!isset($listaEmpresas)): ?>
                            <div class="col-xxl-6 col-xl-8">
                                <h4>Datos de la Empresa</h4>
                                <p>Agrega una nueva empresa para mostrar los datos en esta seccion.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($listaEmpresas as $empresa): ?>
                                <div class="card card-collapsable">
                                    <a class="card-header" href="#DatosEmpresa-<?= esc($empresa['idempresa']) ?>" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        Empresa: <?= esc($empresa['nombre_empresa']) ?>
                                        <div class="card-collapsable-arrow">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="DatosEmpresa-<?= esc($empresa['idempresa']) ?>">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-xxl-6 col-xl-8">
                                                    <h4 class="card-title mb-4">Datos de la empresa</h4>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Empresa:</em></div>
                                                        <div class="col"><?= esc($empresa['nombre_empresa']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Mision:</em></div>
                                                        <div class="col"><?= esc($empresa['mision']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Sector:</em></div>
                                                        <div class="col"><?= esc($empresa['Sector']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Ramo:</em></div>
                                                        <div class="col"><?= esc($empresa['Ramo']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>RFC:</em></div>
                                                        <div class="col"><?= esc($empresa['RFC']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Colonia:</em></div>
                                                        <div class="col"><?= esc($empresa['colonia']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Ciudad:</em></div>
                                                        <div class="col"><?= esc($empresa['ciudad']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Codigo Postal:</em></div>
                                                        <div class="col"><?= esc($empresa['codigo_postal']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Celular:</em></div>
                                                        <div class="col"><?= esc($empresa['celular']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Telefono:</em></div>
                                                        <div class="col"><?= esc($empresa['telefono']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Correo:</em></div>
                                                        <div class="col"><?= esc($empresa['correo']) ?></div>
                                                    </div>
                                                    <br>
                                                    <h6 class="text-truncate"><em>Datos del Titular</em></h6>
                                                    <hr class="my-4" />
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Puesto:</em></div>
                                                        <div class="col"><?= esc($empresa['puesto_titular']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Grado Academico:</em></div>
                                                        <div class="col"><?= esc($empresa['grado_titular']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Nombre:</em></div>
                                                        <div class="col"><?= esc($empresa['nombre_titular']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Primer Apellido:</em></div>
                                                        <div class="col"><?= esc($empresa['apellido1_titular']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Segundo Apellido:</em></div>
                                                        <div class="col"><?= esc($empresa['apellido2_titular']) ?></div>
                                                    </div>
                                                    <br>
                                                    <h6 class="text-truncate"><em>Datos del Asesor Externo</em></h6>
                                                    <hr class="my-4" />
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Puesto:</em></div>
                                                        <div class="col"><?= esc($empresa['puesto']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Grado Academico:</em></div>
                                                        <div class="col"><?= esc($empresa['grado']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Nombre:</em></div>
                                                        <div class="col"><?= esc($empresa['nombre']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Primer Apellido:</em></div>
                                                        <div class="col"><?= esc($empresa['apellido1']) ?></div>
                                                    </div>
                                                    <div class="row small text-muted">
                                                        <div class="col-sm-3 text-truncate"><em>Segundo Apellido:</em></div>
                                                        <div class="col"><?= esc($empresa['apellido2']) ?></div>
                                                    </div>
                                                    <hr class="my-4" />
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-light" type="button">Eliminar</button>
                                                        <button class="btn btn-primary" type="button">Nueva Empresa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade show active" id="agregarempresa" role="tabpanel" aria-labelledby="agregarempresa-tab">
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
                                            <input class="form-control" id="nombre_empresa" name="nombre_empresa" type="text" placeholder="Ingresa el nombre de la empresa" />
                                        </div>
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="mision">Misión</label>
                                            <input class="form-control" id="mision" name="mision" type="text" placeholder="Mision de la empresa" />
                                        </div>
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="RFC">RFC de la Empresa</label>
                                            <input class="form-control" id="RFC" name="RFC" type="text" placeholder="RFC de la empresa" />
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
                                            <input class="form-control" id="colonia" name="colonia" type="text" placeholder="Colonia de la empresa" />
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col md-3">
                                            <label class="small mb-1" for="ciudad">Ciudad</label>
                                            <input class="form-control" id="ciudad" name="ciudad" type="text" placeholder="Ciudad de la empresa" />
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col-md-3">
                                            <label class="small mb-1" for="codigo_postal">Código Postal</label>
                                            <input class="form-control" id="codigo_postal" name="codigo_postal" type="text" placeholder="CP Empresa" />
                                        </div>
                                    </div>
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (telefono empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="telefono">Teléfono Empresa</label>
                                            <input class="form-control" id="telefono" name="telefono" type="text" placeholder="Ingresa el telefono de la empresa" />
                                        </div>
                                        <!-- Form Group (celular empresa)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="celular">Celular Empresa</label>
                                            <input class="form-control" id="celular" name="celular" type="text" placeholder="Ingresa el celular de la empresa" />
                                        </div>
                                        <!-- Form Group (email empresa)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="correo">Correo Empresa</label>
                                            <input class="form-control" id="correo" name="correo" type="email" placeholder="Ingresa el correo de la empresa" />
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
                                                <input class="form-control" id="puesto_titular" name="puesto_titular" type="text" placeholder="Ingresa el puesto del Titular" />
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col-md-3">
                                                <label class="small mb-1" for="grado_titular">Grado Académico</label>
                                                <input class="form-control" id="grado_titular" name="grado_titular" type="text" placeholder="Lic.,Ma., Dr., etc." />
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col md-6">
                                                <label class="small mb-1" for="nombre_titular">Nombre(s)</label>
                                                <input class="form-control" id="nombre_titular" name="nombre_titular" type="text" placeholder="Ingresa el nombre de Titular" />
                                            </div>
                                        </div>
                                        <!-- Form Row        -->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (organization name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="apellido1_titular">Primer Apellido</label>
                                                <input class="form-control" id="apellido1_titular" name="apellido1_titular" type="text" placeholder="Ingresa el Primer Apellido" />
                                            </div>
                                            <!-- Form Group (organization name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="apellido2_titular">Segundo Apellido</label>
                                                <input class="form-control" id="apellido2_titular" name="apellido2_titular" type="text" placeholder="Ingresa el Segundo Apellido" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Agregar Empresa</button>
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
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a> y de la <a href="<?=base_url('/usuario/residentes/empresa')?>">empresa</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Formal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a>, de la <a href="<?=base_url('/usuario/residentes/empresa')?>">empresa</a> y agregar informacion del <a href="<?=base_url('/usuario/residentes/empresa_asesor_externo')?>">Asesor Externo</a>.</td>
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