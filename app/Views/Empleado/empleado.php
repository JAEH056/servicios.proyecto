<?= $this->extend($template ?? 'Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_empleado') ?>
<!-- Main page content-->
<div class="container-xl px-4 mt-n5">
    <div class="row">
        <div id="solid">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Detalles de la cuenta</div>
                <div class="card-body">
                    <!-- Component Preview-->
                    <div class="sbp-preview">
                        <div class="sbp-preview-content">
                            <form>
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputNombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control form-control-solid" id="inputNombreUsuario" type="text" placeholder="Nombre de usuario" />
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputNombre">Nombre:</label>
                                        <input class="form-control form-control-solid" id="inputNombre" type="text" placeholder="Nombre" />
                                    </div>
                                    <!-- Form Group (last name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputApellidos">Apellidos:</label>
                                        <input class="form-control form-control-solid" id="inputApellidos" type="text" placeholder="Apellidos" />
                                    </div>
                                </div>
                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPuesto">Puesto:</label>
                                        <input class="form-control form-control-solid" id="inputPuesto" type="text" placeholder="Puesto" />
                                    </div>
                                    <!-- Form Group (location)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputGradoAcademico">Grado académico:</label>
                                        <input class="form-control form-control-solid" id="inputGradoAcademico" type="text" placeholder="Grado académico" />
                                    </div>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputNombreGradoAcademico">Nombre del grado académico:</label>
                                        <input class="form-control form-control-solid" id="inputNombreGradoAcademico" type="text" placeholder="Nombre del grado académico" />
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCarrera">Carrera:</label>
                                        <input class="form-control form-control-solid" id="inputCarrera" type="text" name="carrera" placeholder="Carrera" />
                                    </div>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputSiglasGradoAcademico">Siglas del grado académico:</label>
                                        <input class="form-control form-control-solid" id="inputSiglasGradoAcademico" type="text" placeholder="Siglas del grado académico" />
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFechaObtencionGradoAcademico">Fecha de obtención del grado académico:</label>
                                        <input class="form-control form-control-solid" id="inputFechaObtencionGradoAcademico" type="text" name="grado" placeholder="Fecha de obtención del grado académico" />
                                    </div>
                                </div>
                                <!-- Save changes button-->
                                <button class="btn btn-primary" type="button">Guardar cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>