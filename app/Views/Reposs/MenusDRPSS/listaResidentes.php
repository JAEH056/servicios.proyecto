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
                        <button class="btn btn-blue btn-icon">
                            <i data-feather="share"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Numero de Control</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Carrera</th>
                                <th>Proyecto</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero de Control</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Carrera</th>
                                <th>Proyecto</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($listaResidentes as $row): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2"><img class="avatar-img img-fluid" src="<?= base_url('resources/assets/img/illustrations/profiles/profile-1.png') ?>" /></div>
                                            <?= esc($row['numero_control']) ?>
                                        </div>
                                    </td>
                                    <td><?= esc($row['nombre']) ?></td>
                                    <td><?= esc($row['apellido1']) ?> <?= esc($row['apellido2']) ?></td>
                                    <td><?= esc($row['nombre_programa_educativo']) ?></td>
                                    <td><?= esc($row['nombre_proyecto']) ?></td>
                                    <td><?= esc($row['nombre_empresa']) ?></td>
                                    <td>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i></a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Documentos">
                                            <i class="fa-regular fa-file"></i></a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Perfil">
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