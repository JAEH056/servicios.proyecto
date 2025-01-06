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
                        <a class="nav-link active" id="overview-tab" href="#datosProyecto" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Datos de Proyecto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="<?= base_url('usuario/residentes/asesor_interno')?>"  aria-controls="example" aria-selected="false">Asesor Interno</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#solicitudResidencias" data-bs-toggle="tab" role="tab" aria-controls="download" aria-selected="false">Solicitud de Residencias</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="datosProyecto" role="tabpanel" aria-labelledby="overview-tab">
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
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Agrega la información solicitada.</h4>
                                    <p>Ingresa los datos solicitados, esta informacion sera usada posteriormente para los formatos necesarios en el proceso de residencias profesionales.</p>
                                </div>
                                <form>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (username)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre_empresa">Nombre del Proyecto</label>
                                            <input class="form-control" id="nombre_empresa" type="text" placeholder="Ingresa el nombre del proyecto" value="" />
                                        </div>
                                        <!-- Menu seleccion opcion (propia o banco) -->
                                        <div class="col-md-6">
                                            <label class="small mb-1" name="seguroSocial" for="seguroSocial">Opción elegida</label>
                                            <select class="form-control" id="seguroSocial" name="seguroSocial">
                                                <option>Propuesta Propia</option>
                                                <option>Banco de Proyectos</option>
                                            </select>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="datepicker">Periodo del proyecto</label>
                                            <input class="form-control" id="datepicker" />
                                        </div>
                                        <!-- Form Group (username)-->

                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre_empresa">Nombre de la empresa</label>
                                            <?php if (isset($datosEmpresa)): ?>
                                                <select class="form-control" id="nombre_empresa" name="idempresa">
                                                    <option value="<?= esc($datosEmpresa['idempresa']) ?>"><?= esc($datosEmpresa['nombre_empresa']) ?></option>
                                                </select>
                                            <?php else: ?>
                                                <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" placeholder="Ingresa el nombre del proyecto" value="" />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="button">Crear Proyecto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="solicitudResidencias" role="tabpanel" aria-labelledby="download-tab">
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
                                        <td><i data-feather="file-text"></i>Solicitud de Residencias</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a> e información de la <a href="<?= base_url('usuario/residentes/empresa') ?>">empresa y asesor externo</a>.</td>
                                        <td><a class="btn btn-primary" href="<?= base_url('usuario/residentes/solicitud-residencias') ?>" target="_blank">Descargar</a></td>
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
<script>
    const picker = new easepick.create({
        element: document.getElementById('datepicker'),
        css: [
            "https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css"
        ],
        zIndex: 10,
        lang: 'es-ES',
        plugins: [
            "RangePlugin"
        ],
        RangePlugin: {
            locale: {
                one: 'día',
                other: 'días',
            },
        },

    });
</script>
<?= $this->endSection(); ?>