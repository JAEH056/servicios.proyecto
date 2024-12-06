<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('content_agregar_horario') ?>
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Agregar horario</span>
        </div>
        <div class="card-body">
            <!--MENSAJE DE EXITO O ERROR  -->
            <?php if(session()->get('success')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        alert('<?= esc(session()->get('success')) ?>');
                        window.location.href = '/horario'; // Redirige a la página principal después del alert
                    });
                </script>
                <?php endif; ?>

            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <!-- Abrir formulario con Form Helper -->
                    <?= form_open('semestre/crear', ['id' => 'form-semestre']) ?>
                    <?= csrf_field() ?>
                    <!-- Selector semestre -->
                    <div class="mb-3">
                        <?= form_label('Semestre', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'nombre',
                            [
                                        ''=> 'Seleccionar semestre',
                                        // '1' => 'Activo',
                                        // '0' => 'Inactivo'
                                    ],
                            set_value('semestre' ?? ''),
                            ['id' => 'semestre', 'class' => 'form-control form-control-solid']
                        ) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('semestre') : '' ?></span>
                    </div>
                    <!-- Selector Laboratorio -->
                    <div class="mb-3">
                        <?= form_label('Laboratorio', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'nombre',
                            [
                                        ''=> 'Seleccionar laboratorio',
                                        // '1' => 'Activo',
                                        // '0' => 'Inactivo'
                                    ],
                            set_value('laboratorio' ?? ''),
                            ['id' => 'laboratorio', 'class' => 'form-control form-control-solid']
                        ) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('laboratorio') : '' ?></span>
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
