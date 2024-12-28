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
                            <?= form_open('#', ['id' => 'form-empleado']) ?>
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
                                <div class="mb-3">
                                    <!-- Form Input (puesto)-->
                                    <?= form_label('Puesto:', 'inputPuesto', ['class' => 'small mb-1']) ?>
                                    <?= form_input([
                                        'name' => 'puesto',
                                        'id' => 'inputPuesto',
                                        'type' => 'text',
                                        'value' => esc($puesto['cargo']),
                                        'class' => 'form-control form-control-solid',
                                        'disabled' => true,
                                        'placeholder' => 'Sin información disponible'
                                    ]) ?>
                                </div>

                                <!-- Form Input (grado académico)-->
                                <div class="mb-3">
                                    <?php if (!empty($grados)): ?>
                                        <?php foreach ($grados as $grado): ?>
                                            <?= form_label('Carrera:', 'inputCarrera', ['class' => 'small mb-1']) ?>
                                            <?= form_input([
                                                'name' => 'programa_educativo',
                                                'id' => 'inputCarrera',
                                                'type' => 'text',
                                                'value' => esc($grado['programa_educativo']),
                                                'class' => 'form-control form-control-solid',
                                                'disabled' => true,
                                                'placeholder' => 'Sin información disponible'
                                            ]) ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No hay grados académicos disponibles.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (nivel académico) -->
                                    <div class="col-md-6">
                                        <?php if (!empty($grados)): ?>
                                            <?php foreach ($grados as $grado): ?>
                                                <?= form_label('Nivel académico:', 'inputNivelAcadémico', ['class' => 'small mb-1']) ?>
                                                <?= form_input([
                                                    'name' => 'nombre_nivel',
                                                    'id' => 'idnivel',
                                                    'type' => 'text',
                                                    'value' => esc($grado['nombre_nivel']),
                                                    'class' => 'form-control form-control-solid',
                                                    'disabled' => true,
                                                    'placeholder' => 'Sin información disponible'
                                                ]) ?>

                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No hay grados académicos disponibles.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Form Group (birthday)-->
                                    
                                    <div class="col-md-6">
                                        <?php if (!empty($grados)): ?>
                                            <?php foreach ($grados as $grado): ?>
                                                <?= form_label('Grado Académico:', 'inputGrado_', ['class' => 'small mb-1']) ?>
                                                <?= form_input([
                                                    'name' => 'grado',
                                                    'id' => 'grado',
                                                    'type' => 'text',
                                                    'value' => esc($grado['nombre_grado']),
                                                    'class' => 'form-control form-control-solid',
                                                    'disabled' => true,
                                                    'placeholder' => 'Sin información disponible'
                                                ]) ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No hay grados académicos disponibles.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <?php if (!empty($grados)): ?>
                                            <?php foreach ($grados as $grado): ?>
                                                <?= form_label('Siglas del grado académico:', 'inputSiglasGradoAcademico', ['class' => 'small mb-1']) ?>
                                                <?= form_input([
                                                    'name' => 'siglas',
                                                    'id' => 'inputSiglasGradoAcademico',
                                                    'type' => 'text',
                                                    //'value' => isset($siglas) && $siglas !== '' ? esc($siglas) : '',
                                                    'value' => esc($grado['siglas']),
                                                    'class' => 'form-control form-control-solid',
                                                    'disabled' => true,
                                                    'placeholder' => 'Sin información disponible'
                                                ]) ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No hay grados académicos disponibles.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <?php if (!empty($grados)): ?>
                                            <?php foreach ($grados as $grado): ?>
                                                <?= form_label('Fecha de obtención del grado académico:', 'inputFechaObtencionGradoAcademico', ['class' => 'small mb-1']) ?>
                                                <?= form_input([
                                                    'name' => 'fecha_grado',
                                                    'id' => 'inputFechaObtencionGradoAcademico',
                                                    'type' => 'date',
                                                    'value' => esc($grado['fecha_creacion']),
                                                    //'value' => isset($fecha_grado) && $fecha_grado !== '' ? esc($fecha_grado) : '',
                                                    'class' => 'form-control form-control-solid',
                                                    'disabled' => true,
                                                    'placeholder' => 'Sin información disponible'
                                                ]) ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No hay grados académicos disponibles.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Botón de Editar -->
                                <div class="d-flex justify-content-end">
                                    <?= form_button('edit', 'Editar Perfil', [
                                        'type' => 'button',
                                        'class' => 'btn btn-primary',
                                        'onclick' => "window.location.href='" . base_url('/usuario/editar/perfil') . "'",
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