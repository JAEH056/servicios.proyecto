<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('Reposs/MenusDRPSS/inicioDRPSS') ?>
<?= $this->section('contenido') ?>
<main>
    <?= $this->include('Reposs/Plantilla/mainHeaderDRPSS'); ?>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="container-fluid px-4">
            <div class="card card-header-actions mx-auto">
                <div class="card-header">
                    Lista de Residentes
                    <div>
                        <button class="btn btn-pink btn-icon mr-2">
                            <i data-feather="heart"></i>
                        </button>
                        <button class="btn btn-teal btn-icon mr-2">
                            <i data-feather="bookmark"></i>
                        </button>
                        <button class="btn btn-blue btn-icon mr-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nuevo Proyecto">
                            <i class="fa-solid fa-user-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Nonmbre del Proyecto</th>
                                <th>Nombre de la empresa</th>
                                <th>Asesor Interno</th>
                                <th>Periodo</th>
                                <th>Tipo Proyecto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre del Proyecto</th>
                                <th>Nombre de la empresa</th>
                                <th>Asesor Interno</th>
                                <th>Periodo</th>
                                <th>Tipo Proyecto</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($listaProyectos as $row): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?= esc($row['nombre_proyecto']) ?>
                                        </div>
                                    </td>
                                    <td><?= esc($row['nombre_empresa']) ?></td>
                                    <td><?= esc($row['grado_academico'] . ' ' . $row['nombre'] . ' ' . $row['apellido1']. ' ' . $row['apellido2']) ?></td>
                                    <td><?= esc($row['fecha_inicio'] . ' - ' . $row['fecha_fin']) ?></td>
                                    <td><?= esc($row['banco_proyecto']) ?></td>
                                    <td>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar" href="<?= base_url('usuario/drpss/editar/' . $row['numero_control']) ?>">
                                            <i class="fa-solid fa-pen-to-square"></i></a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Documentos" href="<?= base_url('usuario/drpss/documentos/' . $row['numero_control']) ?>">
                                            <i class="fa-regular fa-file"></i></a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Perfil" href="<?= base_url('usuario/drpss/perfil/' . $row['numero_control']) ?>">
                                            <i class="fa-solid fa-user"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>