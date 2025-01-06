<?= $this->extend('Reposs/MenusDRPSS/inicioDRPSS') ?>

<?= $this->section('contenido') ?>

<!-- Modal Structure -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Documento PDF</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src="" style="
                width: 100%;
                height: 70vh;
                border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="downloadLink" href="" class="btn btn-primary" download>Descargar</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<main>
    <?= $this->include('Reposs/Plantilla/mainHeaderDRPSS'); ?>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="container-fluid px-4">
            <div class="card card-header-actions mx-auto">
                <div class="card-body">
                    <!-- Account page navigation-->
                    <nav class="nav nav-borders">
                        <a class="nav-link" href="<?= base_url('usuario/drpss/perfil/' . $datosResidente['numero_control']) ?>">Perfil</a>
                        <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/documentos/' . $datosResidente['numero_control']) ?>">Documentos</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/proyecto/' . $datosResidente['numero_control']) ?>">Proyecto</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/liberacion/' . $datosResidente['numero_control']) ?>">Liberacion</a>
                    </nav>
                    <hr class="mt-0 mb-4" />
                    <div class="row">
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
                        <?php if (empty($documentos)): ?>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">Documentos Residente</div>
                                    <div class="card-body">
                                        <div class="alert alert-info" role="alert">
                                            No hay documentos registrados para mostrar.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($documentos as $doc) : ?>
                                <!-- Account details card-->
                                <div class="col-xl-8">
                                    <div class="card mb-4">
                                        <div class="card-header">Nombre del Documento:<div style="color: black;"><?= esc($doc['tipo_archivo_nombre']) ?></div>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?= base_url('usuario/drpss/documentos/validar/'.$doc['numero_control'])?>" method="post">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" id="idvalidacion" name="idvalidacion" value="<?= esc($doc['idvalidacion']) ?>" />
                                                <input type="hidden" id="iddocumento" name="iddocumento" value="<?= esc($doc['iddocumento']) ?>" />
                                                <input type="hidden" id="idpuesto" name="idpuesto" value="<?= esc($puestoId) ?>" />
                                                <!-- Form Row-->
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group (first name)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="fecha_entrega">Fecha de entrega</label>
                                                        <input class="form-control" id="fecha_entrega" type="text" placeholder="Ingresa el primer Apellido" value="<?= esc($doc['fecha_entrega']) ?>" />
                                                    </div>
                                                    <!-- Form Group (last name)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="selecestado">Estado</label>
                                                        <select class="form-control" id="selecestado" name="estado">
                                                            <option><?= $doc['estado'] ?></option>
                                                            <option>Validado</option>
                                                            <option>Rechazado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Form Row        -->
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="apellido2">Observaciones</label>
                                                    <textarea class="lh-base form-control" type="text" name="observaciones" placeholder="Ingresa las observaciones necesarias..." rows="2"><?= esc($doc['observaciones']) ?></textarea>
                                                </div>
                                                <!-- Save changes button-->
                                                <div class="d-flex justify-content-between">
                                                    <a type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#pdfModal" onclick="loadPDF('<?= $doc['archivo'] ?>')">
                                                        <div class="dropdown-item-icon"><i data-feather="download"></i></div>
                                                        Archivo
                                                    </a>
                                                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- Sub menu para navegacion -->
                        <div class="col-xl-4" style="position: sticky;">
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Informacion General</div>
                                <div class="card-body">
                                    <div class="nav-sticky">
                                        <div class="card-body">
                                            <ul class="nav flex-column" id="stickyNav">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#default">Default Colors</a>
                                                    <ul class="nav flex-column ms-3">
                                                        <li class="nav-item"><label class="nav-link" style="color: grey;">Nombre Documento</label></li>
                                                        <li class="nav-item"><a class="nav-link" href="#defaultOutline">Outline</a></li>
                                                    </ul>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" href="#transparent">Transparent</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#sizing">Sizing</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#social">Social</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#extending">Extending</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function loadPDF(pdfFile) {
        const baseUrl = '<?= base_url('usuario/drpss/documentos/descargar/') ?>'; // Adjust the base URL as necessary
        document.getElementById('pdfIframe').src = baseUrl + pdfFile;
        document.getElementById('downloadLink').href = baseUrl + pdfFile;
    }
</script>
<?= $this->endsection() ?>