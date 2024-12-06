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
                        <a class="nav-link active" id="overview-tab" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Documentacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="example-tab" href="#example" data-bs-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Estado de entrega</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="row justify-content-center">
                            <h5 class="card-title">Cargar Documentos</h5>
                            <!-- Mensajes de error -->
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('message') ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>
                            <!-- Form to kardex file -->
                            <form action="<?= site_url('upload/submit') ?>" method="post" enctype="multipart/form-data">
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Nombre archivo)-->
                                    <label for="file">Subir Kardex</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                        <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                    </div>
                                    <!-- Form Group (boton carga)-->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Subir Documento</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form to Constancia SS file -->
                            <form action="<?= site_url('upload/submit') ?>" method="post" enctype="multipart/form-data">
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Nombre archivo)-->
                                    <label for="file">Subir Constancia Servicio Social</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                        <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                    </div>
                                    <!-- Form Group (boton de carga)-->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Subir Documento</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form to Constancia Actividades Complementarias file -->
                            <form action="<?= site_url('upload/submit') ?>" method="post" enctype="multipart/form-data">
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Nombre archivo)-->
                                    <label for="file">Subir Constancia de Actividades Complementarias</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                        <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                    </div>
                                    <!-- Form Group (boton de carga)-->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Subir Documento</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form to Pago reinscripcion file -->
                            <form action="<?= site_url('upload/submit') ?>" method="post" enctype="multipart/form-data">
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Nombre archivo)-->
                                    <label for="file">Subir Pago de Reinscripcion</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                        <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                    </div>
                                    <!-- Form Group (boton de carga)-->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Subir Documento</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="example" role="tabpanel" aria-labelledby="example-tab">
                        <h5 class="card-title">Documentos Entregados</h5>
                        <!-- Form Row-->
                        <!-- Main page content-->
                        <div class="container-fluid px-4">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Nombre del Documento</th>
                                                <th>Fecha de entrega</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nombre del Documento</th>
                                                <th>Fecha de entrega</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td>Boots on the Ground, Inclusive Thought Provoking Ideas</td>
                                                <td>20 Jun 2021</td>
                                                <td>
                                                    <div class="badge bg-gray-200 text-dark">Entregado</div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Invest In Social Impact</td>
                                                <td>19 Jun 2021</td>
                                                <td>
                                                    <div class="badge bg-yellow-soft text-yellow">Rechazado</div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Save the World, Social Entrepreneur</td>
                                                <td>18 Jun 2021</td>
                                                <td>
                                                    <div class="badge bg-green-soft text-green">Aprovado</div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js')?>"></script>
<?= $this->endSection(); ?>