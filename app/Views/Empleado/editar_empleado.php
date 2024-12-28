<?= $this->extend($template ?? 'Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_editar_empleado') ?>
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
                            <?= form_open('usuario/actualizar/perfil', ['id' => 'form-empleado', 'class' => 'form-class', 'method' => 'post']) ?>
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
                                <!-- Nuevo contenedor para agregar grado académico (inicialmente oculto) -->
                                <div id="nuevoGradoAcademico" class="mb-3">
                                    <!-- Form Input (grado académico)-->

                                    <!-- Form Input (grado académico) -->
                                    <div class="form-group">
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
                                                        // 'disabled' => true,
                                                        'placeholder' => 'Sin información disponible'
                                                    ]) ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No hay grados académicos disponibles.</p>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('programa_educativo') : '' ?></span>
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
                                                    // 'disabled' => true // Deshabilitado para no permitir la edición
                                                ]
                                            ) ?>
                                            <?= form_hidden('idnivel', $nivelSeleccionado ?? set_value('idnivel')) ?> <!-- Campo oculto para enviar el valor -->
                                            <span class="text-danger"><?= isset($validation) ? $validation->getError('idnivel') : '' ?></span>
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
                                                    // 'disabled' => true,
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
                                            <?= form_label('Siglas del grado académico:', 'inputSiglasGradoAcademico', ['class' => 'small mb-1']) ?>
                                            <?= form_input([
                                                'name' => 'siglas',
                                                'id' => 'inputSiglasGradoAcademico',
                                                'type' => 'text',
                                                'value' => isset($siglas) && $siglas !== '' ? esc($siglas) : '',
                                                'class' => 'form-control form-control-solid',
                                                // 'disabled' => true,
                                                'placeholder' => 'Escriba las siglas del agrado académico'
                                            ]) ?>
                                            <span class="text-danger"><?= isset($validation) ? $validation->getError('siglas') : '' ?></span>
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
                                                   // 'disabled' => true,
                                                    'placeholder' => 'Sin información disponible'
                                                ]) ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No hay grados académicos disponibles.</p>
                                        <?php endif; ?>
                                            <span class="text-danger"><?= isset($validation) ? $validation->getError('fecha_creacion') : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <!-- Nueva fila para el botón de agregar grado académico (aparece antes) -->
                                    <div class="w-100 mb-3">
                                        <?= form_button([
                                            'type' => 'button',
                                            'id' => 'agregarGradoBtn',
                                            'class' => 'btn btn-link',
                                            'content' => 'Agregar otro grado académico'
                                        ]) ?>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-end mb-3">
                                    <?= form_submit('submit', 'Actualizar perfil', ['class' => 'btn btn-primary me-2']) ?>
                                    <?= form_button('cancel', 'Cancelar', [
                                        'type' => 'button',
                                        'class' => 'btn btn-secondary',
                                        'onclick' => 'history.back()',
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


<?= $this->section('inline_javascript') ?>
<script>
    document.getElementById('agregarGradoBtn').addEventListener('click', function() {
        // Crear un nuevo contenedor para el grado académico
        var nuevoGradoAcademico = document.createElement('div');
        nuevoGradoAcademico.classList.add('mb-3');

        // Crear el campo para la carrera (en una fila independiente)
        var rowCarrera = document.createElement('div');
        rowCarrera.classList.add('mb-3');
        rowCarrera.innerHTML = `
            <label class="small mb-1" for="inputCarrera">Carrera:</label>
            <input type="text" name="programa_educativo[]" class="form-control form-control-solid" placeholder="Escriba la carrera" />
        `;

        // Crear la fila con los campos (nivel académico y grado académico)
        var row1 = document.createElement('div');
        row1.classList.add('row', 'gx-3', 'mb-3');

        // Campo para nivel académico
        var colNivel = document.createElement('div');
        colNivel.classList.add('col-md-6');
        colNivel.innerHTML = `
            <label class="small mb-1" for="inputNivelAcadémico">Nivel académico:</label>
            <select name="idnivel[]" class="form-control form-control-solid" id="inputNivelAcadémico">
                <option value="">Seleccionar nivel</option>
                <?php foreach ($niveleducativo as $nivel): ?>
                    <option value="<?= $nivel['idnivel'] ?>"><?= esc($nivel['nombre_nivel']) ?></option>
                <?php endforeach; ?>
            </select>
        `;

        // Campo para grado académico
        var colGrado = document.createElement('div');
        colGrado.classList.add('col-md-6');
        colGrado.innerHTML = `
            <label class="small mb-1" for="inputNombreGradoAcademico">Grado académico:</label>
            <input type="text" name="inputGrado[]" class="form-control form-control-solid" placeholder="Escriba el grado académico" />
        `;

        row1.appendChild(colNivel);
        row1.appendChild(colGrado);

        // Crear la fila con los campos (siglas y fecha de obtención)
        var row2 = document.createElement('div');
        row2.classList.add('row', 'gx-3', 'mb-3');

        // Campo para siglas
        var colSiglas = document.createElement('div');
        colSiglas.classList.add('col-md-6');
        colSiglas.innerHTML = `
            <label class="small mb-1" for="inputSiglasGradoAcademico">Siglas del grado académico:</label>
            <input type="text" name="siglas[]" class="form-control form-control-solid" placeholder="Escriba las siglas del grado académico" />
        `;

        // Campo para fecha de obtención
        var colFecha = document.createElement('div');
        colFecha.classList.add('col-md-6');
        colFecha.innerHTML = `
            <label class="small mb-1" for="inputFechaObtencionGradoAcademico">Fecha de obtención del grado académico:</label>
            <input type="date" name="fecha_grado[]" class="form-control form-control-solid" placeholder="Seleccione la fecha de obtención del grado académico" />
        `;

        row2.appendChild(colSiglas);
        row2.appendChild(colFecha);

        // Agregar todas las filas al contenedor principal
        nuevoGradoAcademico.appendChild(rowCarrera); // Carrera en fila independiente
        nuevoGradoAcademico.appendChild(row1); // Nivel y Grado Académico
        nuevoGradoAcademico.appendChild(row2); // Siglas y Fecha de Obtención

        // Obtener el contenedor de los botones
        var formEmpleado = document.getElementById('form-empleado');
        var botonContenedor = document.querySelector('.d-flex.justify-content-end.mb-3'); // Contenedor de los botones

        // Insertar el nuevo grado antes de los botones
        formEmpleado.insertBefore(nuevoGradoAcademico, botonContenedor);
    });
</script>

<?= $this->endSection() ?>