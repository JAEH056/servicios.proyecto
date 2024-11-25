<?= $this->extend('Labs/layouts/principal') ?>
<?= $this->section('content_semestre') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Semestre</span>
                <button class="btn btn-primary ms-auto" type="button">Agregar</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot> -->
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-solid fa-pen"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-solid fa-pen"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-solid fa-pen"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-solid fa-pen"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-solid fa-pen"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>


<?= $this->section('inline_javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src= "<?=base_url("resources/js/datatables/datatables-simple-demo.js") ?>" ></script>
<?= $this->endSection() ?>