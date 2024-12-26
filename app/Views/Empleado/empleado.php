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
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>


                    <!-- Component Preview-->
                    <div class="sbp-preview">
                        <div class="sbp-preview-content">
                            <?= form_open('empleado/editar', ['id' => 'form-empleado']) ?>
                            <?= csrf_field() ?>
                            <!-- Form Input (Nombre de usuario (correo))-->
                            <div class="mb-3">
                                <?= form_label('Nombre de usuario:', 'inputNombreUsuario', ['class' => 'small mb-1']) ?>
                                <?= form_input([
                                    'name' => 'username',
                                    'id' => 'inputNombreUsuario',
                                    'type' => 'text',
                                    'value' => esc($datosUsuario['principal_name']),
                                    'class' => 'form-control form-control-solid',
                                    'disabled' => true,
                                    'placeholder' => 'Sin información disponible'
                                ]) ?>
                            </div>
                            <!-- Form Input (Nombre)-->
                            <div class="mb-3">
                                <?= form_label('Nombre:', 'inputNombre', ['class' => 'small mb-1']) ?>
                                <?= form_input([
                                    'name' => 'first_name',
                                    'id' => 'inputNombre',
                                    'type' => 'text',
                                    'value' => esc($datosUsuario['nombre']),
                                    'class' => 'form-control form-control-solid',
                                    'disabled' => true,
                                    'placeholder' => 'Sin información disponible'
                                ]) ?>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Input (primer apellido)-->
                                <div class="col-md-6">
                                    <?= form_label('Primer apellido:', 'inputPrimerApellido', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'last_name_one',
                                        'id' => 'inputPrimerApellido',
                                        'type' => 'text',
                                        'value' => esc($datosUsuario['apellido1']),
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                                <!-- Form Input (segundo apellido)-->
                                <div class="col-md-6">
                                    <?= form_label('Segundo apellido:', 'inputSegundoApellido', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'last_name_two',
                                        'id' => 'inputSegundoApellido',
                                        'type' => 'text',
                                        'value' => esc($datosUsuario['apellido2']),
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                            </div>
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Input (puesto)-->
                                <div class="col-md-6">
                                    <?= form_label('Puesto:', 'inputPuesto', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'position',
                                        'id' => 'inputPuesto',
                                        'type' => 'text',
                                        'value' => isset($jobTitle) && !empty($jobTitle) ? esc($jobTitle) : '',
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>

                                <!-- Form Input (grado académico)-->
                                <div class="col-md-6">
                                    <?= form_label('Grado académico:', 'inputNombreGradoAcademico', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'inputGrado',
                                        'id' => 'inputNombreGradoAcademico',
                                        'type' => 'text',
                                        'value' => isset($grado) && $grado !== '' ? esc($grado) : '',
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (nivel académico) -->
                                <div class="col-md-6">
                                    <?= form_label('Nivel académico:', 'inputNivelAcadémico', ['class' => 'small mb-1']) ?>
                                    <?= form_dropdown(
                                        'idnivel_disabled', // Nombre del campo (se muestra pero no se edita)
                                        ['' => 'Seleccionar nivel'] + array_column($niveleducativo, 'nombre_nivel', 'idnivel'),
                                        set_value('idnivel', $nivelSeleccionado ?? ''),
                                        [
                                            'id' => 'idnivel',
                                            'class' => 'form-control form-control-solid',
                                            'disabled' => true // Deshabilitado para no permitir la edición
                                        ]
                                    ) ?>
                                    <?= form_hidden('idnivel', $nivelSeleccionado ?? set_value('idnivel')) ?> <!-- Campo oculto para enviar el valor -->
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('idnivel') : '' ?></span>
                                </div>

                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <?= form_label('Carrera:', 'inputCarrera', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'programa_educativo',
                                        'id' => 'inputCarrera',
                                        'type' => 'text',
                                        'value' => isset($programa_carrera) && $programa_carrera !== '' ? esc($programa_carrera) : '',
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                            </div>

                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <?= form_label('Siglas del grado académico:', 'inputSiglasGradoAcademico', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'siglas',
                                        'id' => 'inputSiglasGradoAcademico',
                                        'type' => 'text',
                                        'value' => isset($siglas) && $siglas !== '' ? esc($siglas) : '',
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <?= form_label('Fecha de obtención del grado académico:', 'inputFechaObtencionGradoAcademico', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'fecha_grado',
                                        'id' => 'inputFechaObtencionGradoAcademico',
                                        'type' => 'text',
                                        'value' => isset($fecha_grado) && $fecha_grado !== '' ? esc($fecha_grado) : '',
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>
                            </div>

                            <!-- Botón de Editar -->
                            <div class="d-flex justify-content-end">
                                <?= form_button('edit', 'Editar Perfil', [
                                    'type' => 'button',
                                    'class' => 'btn btn-primary',
                                    'onclick' => "window.location.href='" . base_url('empleado/editar') . "'",
                                ]) ?>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>