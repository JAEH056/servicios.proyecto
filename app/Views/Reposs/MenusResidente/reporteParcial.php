<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>

<?= $this->section('contenido'); ?>
<main>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Confirmar Eliminación</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">...</div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger mt-2" href="midireccion" type="button" id="confirmDeleteButton">Eliminar Documento</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="reporte-tab" href="#reporteParcial" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Reporte Parcial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="descarga-tab" href="#descargarReporte" data-bs-toggle="tab" role="tab" aria-controls="download" aria-selected="false">Subir reporte</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="reporteParcial" role="tabpanel" aria-labelledby="reporte-tab">
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
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Agrega la información solicitada.</h4>
                                    <p>Ingresa los datos solicitados, esta informacion sera usada posteriormente para los formatos necesarios en el proceso de residencias profesionales.</p>
                                </div>
                                <form action="<?= base_url('usuario/residentes/solicitud-residencias') ?>" method="get">
                                    <?= csrf_field(); ?>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (nombre proyecto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre_proyecto">Nombre del Proyecto</label>
                                            <select class="form-control" id="nombre_proyecto" name="idproyecto">
                                                <option value="">Nombre 1</option>
                                                <option value="">nombre 2</option>
                                            </select>
                                        </div>
                                        <!-- Form Group (Fecha de proyecto)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="datepicker">Periodo del reporte</label>
                                            <input class="form-control" id="datepicker" name="fecha_periodo" placeholder="Selecciona un periodo" />
                                        </div>
                                        <!-- Menu seleccion opcion (tipo reporte) -->
                                        <div class="col-md-6">
                                            <label class="small mb-1" name="seguroSocial" for="banco_proyecto">No. de Reporte</label>
                                            <select class="form-control" id="seguroSocial" name="banco_proyecto">
                                                <option value="">Primer Reporte</option>
                                                <option value="">Segundo Reporte</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Descargar Reporte</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="descargarReporte" role="tabpanel" aria-labelledby="descarga-tab">
                        <h5 class="card-title">Resumen de Información.</h5>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- FORMA PARA SUBIR DOCUMENTOS (PRIMER REPORTE PARCIAL) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('error' . 'reporte_parcial')): ?>
                                <div class="alert alert-danger"><?= session()->get('error' . 'reporte_parcial') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('success' . 'reporte_parcial')): ?>
                                <div class="alert alert-success"><?= session()->get('success' . 'reporte_parcial') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($reporteParcial): ?>
                                <div class="col-md-6">
                                    Ya has subido un reporte(No. Reporte): <strong><?= esc($reporteParcial['iddocumento'] . ', ' . $reporteParcial['archivo']) ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                        data-info="¿Desea eliminar el Documento (<strong>Primer Reporte Parcial</strong>)?" data-href="<?= base_url('usuario/residentes/reporte/10') ?>">Eliminar</button>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/reporte/10/' . $numControl['numero_control']) ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="reporte_parcial">Subir primer reporte parcial</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="reporte_parcial" name="reporte_parcial" required>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS (PRIMER REPORTE PARCIAL)-->

                            <!-- FORMA PARA SUBIR DOCUMENTOS (SEGUNDO REPORTE PARCIAL) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('error' . 'reporte_parcial_2')): ?>
                                <div class="alert alert-danger"><?= session()->get('error' . 'reporte_parcial_2') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('success' . 'reporte_parcial_2')): ?>
                                <div class="alert alert-success"><?= session()->get('success' . 'reporte_parcial_2') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($reporteParcial): ?>
                                <div class="col-md-6">
                                    Ya has subido un reporte(No. Reporte): <strong><?= esc($reporteParcial['iddocumento'] . ', ' . $reporteParcial['archivo']) ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                        data-info="¿Desea eliminar el Documento (<strong>Segundo Reporte Parcial</strong>)?" data-href="<?= base_url('usuario/residentes/reporte/11') ?>">Eliminar</button>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/reporte/11/' . $numControl['numero_control']) ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="reporte_parcial">Subir segundo reporte parcial</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="reporte_parcial" name="reporte_parcial" required>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS (SEGUNDO REPORTE PARCIAL)-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // Listen for the modal show event
    var exampleModal = document.getElementById('exampleModalCenter');
    exampleModal.addEventListener('show.bs.modal', function(event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal

        // Extract info from data-* attributes
        var info = button.getAttribute('data-info');
        var href = button.getAttribute('data-href'); // Get the href from the button

        // Update the modal's content
        var modalBody = exampleModal.querySelector('#modalBody');
        modalBody.innerHTML = info; // Set the content of the modal body

        // Update the href of the confirm button
        var confirmDeleteButton = exampleModal.querySelector('#confirmDeleteButton');
        confirmDeleteButton.setAttribute('href', href); // Set the new href
    });
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
    const picker2 = new easepick.create({
        element: document.getElementById('datepicker2'),
        css: [
            "https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css"
        ],
        zIndex: 10,
        lang: 'es-ES',
        plugins: [
            //"RangePlugin"
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