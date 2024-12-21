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

                            <!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA KARDEX) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('errorkardex')): ?>
                                <div class="alert alert-danger"><?= session()->get('errorkardex') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('successkardex')): ?>
                                <div class="alert alert-success"><?= session()->get('successkardex') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($kardex): ?>
                                <div class="col-md-6">
                                    Ya has subido un documento(Kardex): <strong><?= $kardex['iddocumento'], $kardex['archivo'] ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('usuario/residentes/delete/1') ?>" class="btn btn-danger mt-2">Eliminar Documento</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/upload/1') ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="kardex">Subir Kardex</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="kardex" name="kardex" multiple required>
                                            <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

                            <!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA SERVICIO SOCIAL) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('errorconstanciaSS')): ?>
                                <div class="alert alert-danger"><?= session()->get('errorconstanciaSS') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('successconstanciaSS')): ?>
                                <div class="alert alert-success"><?= session()->get('successconstanciaSS') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($constanciaSS): ?>
                                <div class="col-md-6">
                                    Ya has subido un documento(Cons. Servicio Social.): <strong><?= esc($constanciaSS['iddocumento']), esc($constanciaSS['archivo']) ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('usuario/residentes/delete/2') ?>" class="btn btn-danger mt-2">Eliminar Documento</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/upload/2') ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="constanciaSS">Subir Constancia Servicio Social</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="constanciaSS" name="constanciaSS" required>
                                            <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

                            <!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA ACTIVIDADES COMPLEMENTARIAS) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('errorconstanciaAC')): ?>
                                <div class="alert alert-danger"><?= session()->get('errorconstanciaAC') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('successconstanciaAC')): ?>
                                <div class="alert alert-success"><?= session()->get('successconstanciaAC') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($constanciaAC): ?>
                                <div class="col-md-6">
                                    Ya has subido un documento(Cons. Actividades Complementarias.): <strong><?= $constanciaAC['iddocumento'], $constanciaAC['archivo'] ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('usuario/residentes/delete/3') ?>" class="btn btn-danger mt-2">Eliminar Documento</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/upload/3') ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="constanciaAC">Subir Constancia Actividades Complementarias</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="constanciaAC" name="constanciaAC" required>
                                            <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

                            <!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA PAGO REINSCRIPCION) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('errorpagoReinscripcion')): ?>
                                <div class="alert alert-danger"><?= session()->get('errorpagoReinscripcion') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('successpagoReinscripcion')): ?>
                                <div class="alert alert-success"><?= session()->get('successpagoReinscripcion') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($pagoReinscripcion): ?>
                                <div class="col-md-6">
                                    Ya has subido un documento(Pago de Reinscripcion.): <strong><?= $pagoReinscripcion['iddocumento'], $pagoReinscripcion['archivo'] ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('usuario/residentes/delete/4') ?>" class="btn btn-danger mt-2">Eliminar Documento</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/upload/4') ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="pagoReinscripcion">Subir Pago de Reinscripcion.</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="pagoReinscripcion" name="pagoReinscripcion" required>
                                            <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS -->

                            <!-- FORMA PARA SUBIR DOCUMENTOS (CONSTANCIA VIGENCIA DE SEGURO) -->
                            <!-- Bloque Mensajes: Mostrar mensajes de éxito o error -->
                            <?php if (session()->get('errorvigenciaSeguro')): ?>
                                <div class="alert alert-danger"><?= session()->get('errorvigenciaSeguro') ?></div>
                            <?php endif; ?>
                            <?php if (session()->get('successvigenciaSeguro')): ?>
                                <div class="alert alert-success"><?= session()->get('successvigenciaSeguro') ?></div>
                            <?php endif; ?>
                            <!-- Fin Bloque de mensajes -->
                            <!-- Verificar si ya hay un documento cargado -->
                            <?php if ($vigenciaSeguro): ?>
                                <div class="col-md-6">
                                    Ya has subido un documento(Vigencia de Seguro.): <strong><?= $vigenciaSeguro['iddocumento'], $vigenciaSeguro['archivo'] ?></strong>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('usuario/residentes/delete/5') ?>" class="btn btn-danger mt-2">Eliminar Documento</a>
                                </div>
                            <?php else: ?>
                                <form action="<?= base_url('usuario/residentes/upload/5') ?>" method="POST" enctype="multipart/form-data">
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <?= csrf_field() ?>
                                        <!-- Form Group (Nombre archivo)-->
                                        <label for="vigenciaSeguro">Subir Vigencia de Seguro.</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="vigenciaSeguro" name="vigenciaSeguro" required>
                                            <small class="form-text text-muted">Solo se permiten documentos PDF.</small>
                                        </div>
                                        <!-- Form Group (boton de carga)-->
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Subir Documento</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- FIN FORMA PARA SUBIR DOCUMENTOS -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="example" role="tabpanel" aria-labelledby="example-tab">
                        <h5 class="card-title">Documentos Entregados</h5>
                        <!-- Form Row-->
                        <!-- Main page content-->
                        <div class="container-fluid px-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($estadoDocumentos)): ?>
                                        <table id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>ID Documento</th>
                                                    <th>Archivo</th>
                                                    <th>Nombre</th>
                                                    <th>Estado</th>
                                                    <th>Fecha de entrega</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID Documento</th>
                                                    <th>Archivo</th>
                                                    <th>Nombre</th>
                                                    <th>Estado</th>
                                                    <th>Fecha de entrega</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach ($estadoDocumentos as $row): ?>
                                                    <tr>
                                                        <td><?= esc($row['iddocumento']) ?></td>
                                                        <td><?= esc($row['archivo']) ?></td>
                                                        <td><?= esc($row['nombre']) ?></td>
                                                        <td>
                                                            <div class="badge bg-primary text-white rounded-pill"><?= esc($row['estado']) ?></div>
                                                        </td>
                                                        <td><?= esc($row['fecha_entrega']) ?></td>
                                                        <td>
                                                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No se encontraron documentos.</p>
                                    <?php endif; ?>
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
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection(); ?>