<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('content_agregar_semestre') ?>
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Agregar semestre</span>
        </div>
        <div class="card-body">
            <!--MENSAJE DE EXITO O ERROR  -->
            <?php if(session()->get('success')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        alert('<?= esc(session()->get('success')) ?>');
                        window.location.href = '/semestre'; // Redirige a la página principal después del alert
                    });
                </script>
                <?php endif; ?>

            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <!-- Abrir formulario con Form Helper -->
                    <?= form_open('semestre/crear', ['id' => 'form-semestre']) ?>
                    <?= csrf_field() ?>
                    <!-- Nombre del semestre -->
                    <div class="mb-3">
                        <?= form_label('Nombre', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'nombre',
                            'id' => 'nombre',
                            'type' => 'text',
                            'value' => set_value('nombre'),
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Nombre del semestre',
                        ]) ?>
                    </div>
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('nombre') : '' ?></span>
                    <!-- Fecha de inicio -->
                    <div class="mb-3">
                        <?= form_label('Fecha de inicio', 'inicio', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'inicio',
                            'id' => 'inicio',
                            'type' => 'date',
                            'value' => set_value('inicio'),
                            'class' => 'form-control form-control-solid',
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('inicio') : '' ?></span>
                    </div>
                    <!-- Fecha de fin -->
                    <div class="mb-3">
                        <?= form_label('Fecha de fin', 'fin', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'fin',
                            'id' => 'fin',
                            'type' => 'date',
                            'value' => set_value('fin'),
                            'class' => 'form-control form-control-solid',

                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('fin') : '' ?></span>
                    </div>
                    <!-- Selector estado -->
                    <div class="mb-3">
                        <?= form_label('Estado', 'estado', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'estado',
                            [
                                        ''=> 'Seleccionar estado',
                                        '1' => 'Activo',
                                        '0' => 'Inactivo'
                                    ],
                            set_value('estado' ?? ''),
                            ['id' => 'estado', 'class' => 'form-control form-control-solid']
                        ) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('estado') : '' ?></span>
                    </div>
                    <!-- Botones Guardar y Cancelar -->
                    <div class="mt-3 d-flex justify-content-end">
                        <?= form_submit('submit', 'Guardar', ['class' => 'btn btn-primary me-2']) ?>
                        <?= form_button('cancel', 'Cancelar', [
                            'type' => 'button',
                            'class' => 'btn btn-secondary',
                            'onclick' => "window.location.href='" .base_url('semestre'). "'",
                        ]) ?>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>                       
</div>

<?= $this->endSection() ?>
