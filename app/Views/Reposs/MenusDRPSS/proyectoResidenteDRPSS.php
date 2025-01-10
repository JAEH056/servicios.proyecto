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
                <div class="card-body">
                    <!-- Account page navigation-->
                    <nav class="nav nav-borders">
                        <a class="nav-link" href="<?= base_url('usuario/drpss/perfil/' . $datosResidente['numero_control']) ?>">Perfil</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/documentos/' . $datosResidente['numero_control']) ?>">Documentos</a>
                        <a class="nav-link active ms-0" href="<?= base_url('usuario/drpss/proyecto/' . $datosResidente['numero_control']) ?>">Proyecto</a>
                        <a class="nav-link" href="<?= base_url('usuario/drpss/liberacion/' . $datosResidente['numero_control']) ?>">Liberación</a>
                    </nav>
                    <hr class="mt-0 mb-4" />
                    <div class="col-xl-8">
                        <?php if (empty($proyectos)) : ?>
                            <!-- Account details card-->
                            <div class="card mb-4">
                                <div class="card-header">Detalles del proyecto</div>
                                <div class="card-body">
                                    <!-- Form Group (nombre proyecto)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="numero_control">No hay proyecto</label>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($proyectos as $proyecto) : ?>
                                <!-- Detalles del pryecto card-->
                                <div class="card mb-4">
                                    <div class="card-header">Detalles del proyecto</div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Form Group (nombre proyecto)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="numero_control">Nombre del proyecto</label>
                                                <input class="form-control" id="numero_control" name="numero_control" type="text" value="<?= esc($proyecto['nombre_proyecto']) ?>" />
                                            </div>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (username)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="nombre">Tipo de Propuesta</label>
                                                    <input class="form-control" id="nombre" type="text" name="nombre" value="<?= esc($proyecto['banco_proyecto']) ?>" />
                                                </div>
                                                <!-- Form Group (username)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="correo_institucional">Periodo</label>
                                                    <input class="form-control" id="correo_institucional" name="principal_name" type="text" value="<?= $proyecto['fecha_inicio'] . ' - ' . $proyecto['fecha_fin'] ?>" />
                                                </div>
                                            </div>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="nombre_empresa">Nombre de empresa</label>
                                                    <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" placeholder="Ingresa el primer Apellido" value="<?= esc($proyecto['nombre_empresa']) ?>" />
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="sector">Sector</label>
                                                    <input class="form-control" id="sector" type="text" name="sector" value="<?= esc($proyecto['sector'])?>" />
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="ramo">Ramo</label>
                                                    <input class="form-control" id="ramo" type="text" name="ramo" value="<?= esc($proyecto['ramo'])?>" />
                                                </div>
                                            </div>
                                            <!-- Form Row        -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (Asesor Interno)-->
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="puesto_aint">Puesto Asesor Interno</label>
                                                    <input class="form-control" id="puesto_aint" name="puesto_aint" type="text" value="<?= esc( $proyecto['puesto_aint'])?>" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="nombre_aint">Asesor Interno</label>
                                                    <input class="form-control" id="nombre_aint" name="nombre_aint" type="text" value="<?= esc($proyecto['grado_academico'] .' '. $proyecto['nombre_aint'] .' '. $proyecto['apellido1_aint'] .' '. $proyecto['apellido2_aint']) ?>" />
                                                </div>
                                                <!-- Form Group (Asesor Externo)-->
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="puesto_aext">Puesto Asesor Externo</label>
                                                    <input class="form-control" id="puesto_aext" name="puesto_aext" type="text" value="<?= esc( $proyecto['puesto_aext'])?>" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="nombre_aext">Asesor Externo</label>
                                                    <input class="form-control" id="nombre_aext" name="nombre_aext" type="text" value="<?= esc($proyecto['grado_aext'].' '. $proyecto['nombre_aext'] .' '. $proyecto['apellido1_aext'] .' '. $proyecto['apellido2_aext'])?>" />
                                                </div>
                                            </div>
                                            <!-- Boton para actualizar datos del proyecto-->
                                            <button class="btn btn-primary" type="button">Actualizar Informacion</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endsection() ?>