<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!-- obtiene el contenido de la plantilla de la ruta especificada -->
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>

<?= $this->section('contenido') ?>
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
                        <a class="nav-link active" id="documentos-tab" href="#documentos" data-bs-toggle="tab" role="tab" aria-controls="documentos" aria-selected="true">Documentacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="estadoEntrega-tab" href="#estadoEntrega" data-bs-toggle="tab" role="tab" aria-controls="estadoEntrega" aria-selected="false">Estado de entrega</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                        <div class="row justify-content-center">
                            <h5 class="card-title">Cargar Documentos</h5>
                            <h6><small>Solo se permiten documentos PDF.</small></h6>
                            <!-- INPUTS PARA PRE REQUISITOS Y REQUISITOS -->
                            <?= $this->include('Reposs/MenusResidente/documentos_pre_requisitos') ?>
                            <?= $this->include('Reposs/MenusResidente/documentos_requisitos') ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="estadoEntrega" role="tabpanel" aria-labelledby="estadoEntrega-tab">
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
                                                            <div class="badge bg-primary text-white rounded-pill" style="background-color: rgb(59, 31, 189) ;"><?= esc($row['estado']) ?></div>
                                                        </td>
                                                        <td><?= esc($row['fecha_entrega']) ?></td>
                                                        <td>
                                                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                                            <a class="btn btn-datatable btn-icon btn-transparent-dark" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                                                data-info="¿Desea eliminar el Documento (<strong><?=esc($row['nombre'])?></strong>)?" data-href="<?= base_url('usuario/residentes/delete/' . $row['idtipo']) ?>"><i data-feather="trash-2"></i></a>
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
</script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection(); ?>