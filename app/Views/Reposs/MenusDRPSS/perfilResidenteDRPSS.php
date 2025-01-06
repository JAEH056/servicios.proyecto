<?= $this->extend('Reposs/MenusDRPSS/inicioDRPSS') ?>

<?= $this->section('contenido') ?>

<main>
    <?= $this->include('Reposs/Plantilla/mainHeaderDRPSS'); ?>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="container-fluid px-4">
            <div class="card card-header-actions mx-auto">
                <div class="card-body">
                    <!-- Account page navigation-->
                    <nav class="nav nav-borders">
                        <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/perfil/' . $datosResidente['numero_control']) ?>">Perfil</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/documentos/' . $datosResidente['numero_control']) ?>">Documentos</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/proyecto/' . $datosResidente['numero_control']) ?>">Proyecto</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/liberacion/' . $datosResidente['numero_control']) ?>">Liberacion</a>
                    </nav>
                    <hr class="mt-0 mb-4" />
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Detalles de Residente</div>
                            <div class="card-body">
                                <form>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (username)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="numero_control">Numero de Control</label>
                                            <input class="form-control" id="numero_control" name="numero_control" type="text" placeholder="No hay numero de control" value="<?= $datosResidente['numero_control'] ?>" />
                                        </div>
                                        <!-- Form Group (username)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="correo_institucional">Correo Institucional</label>
                                            <input class="form-control" id="correo_institucional" name="principal_name" type="text" placeholder="No hay correo institucional" value="<?= $datosResidente['principal_name'] ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Group (username)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="nombre">Nombre(s)</label>
                                        <input class="form-control" id="nombre" type="text" name="nombre" placeholder="nombre estudiante" value="<?= $datosResidente['nombre'] ?>" />
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text" name="apellido1" placeholder="Ingresa el primer Apellido" value="<?= $datosResidente['apellido1'] ?>" />
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text" name="apellido2" placeholder="Ingresa el segundo Apellido" value="<?= $datosResidente['apellido2'] ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (organization name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="programa_educativo">Programa educativo</label>
                                            <input class="form-control" id="programa_educativo" name="nombre_programa_educativo" type="text" placeholder="No hay programa educativo" value="<?= $datosResidente['nombre_programa_educativo'] ?>" />
                                        </div>
                                        <!-- Form Group (location)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="nombre_modalidad">Modalidad</label>
                                            <input class="form-control" id="nombre_modalidad" name="nombre_modalidad" type="text" placeholder="No hay modalidad" value="<?= $datosResidente['nombre_modalidad'] ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="seguro_social">Seguro Social</label>
                                            <input class="form-control" id="seguro_social" type="tel" name="seguro_social" placeholder="Seguro social" value="<?= $datosResidente['seguro_social'] ?>" />
                                        </div>
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="numero_seguro">Numero de seguro social</label>
                                            <input class="form-control" id="numero_seguro" type="text" name="numero_ss" placeholder="Numero de seguro social" value="<?= $datosResidente['numero_ss'] ?>" />
                                        </div>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="celular">Celular</label>
                                        <input class="form-control" id="celular" name="celular" type="text" placeholder="Ingrese un numero de celular" value="<?= $datosResidente['celular'] ?>" />
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="button">Actualizar Informacion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endsection() ?>