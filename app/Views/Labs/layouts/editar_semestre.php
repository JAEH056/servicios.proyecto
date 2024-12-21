<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_semestre') ?>

<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar semestre</span>
        </div>
        <div class="card-body">
            <?php if (session()->get('success')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        alert('<?= esc(session()->get('success')) ?>');
                        window.location.href = '/usuario/semestre/mostrar';
                    });
                </script>
            <?php endif; ?>
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <?= form_open('/usuario/semestre/actualizar/' .esc($semestre['id']), ['id' => 'fomr-semestre']) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <?= form_label('Nombre del semestre', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'nombre',
                            'id' => 'nombre',
                            'type' => 'text',
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Nombre del semestre',
                            'value' => set_value('nombre', $semestre['nombre'] ?? null),

                        ]) ?>
                    </div>
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('nombre') : '' ?></span>

                    <div class="mb-3">
                        <?= form_label('Fecha de inicio', 'inicio', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'inicio',
                            'id' => 'inicio',
                            'class' => 'form-control form-control-solid',
                            'type' => 'date',
                            'value' => set_value('inicio', $semestre['inicio'] ?? null),
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('inicio') : '' ?></span>
                    </div>

                    <div class="mb-3">
                        <?= form_label('Fecha de fin', 'fin') ?>
                        <?= form_input([
                            'name' => 'fin',
                            'id' => 'fin',
                            'class' => 'form-control form-control-solid',
                            'type' => 'date',
                            'value' => set_value('fin', $semestre['fin'] ?? null),
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('fin') : '' ?></span>
                    </div>
                    
                    <!-- Selector estado -->
                    <div class="mb-3">
                        <?= form_label('Estado', 'estado', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'estado',
                            [''=>'Seleccionar estado', '1' => 'Activo', '0' => 'Inactivo'],
                            set_value('estado', $semestre['estado'] ?? null),
                            ['id' => 'estado', 'class' => 'form-control form-control-solid']
                        ) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('estado') : '' ?></span>
                    </div>
                                    
                    <!-- Botones Guardar y Cancelar -->
                    <div class="mt-3 d-flex justify-content-end">
                            <?= form_submit('submit', 'Actualizar', ['class' => 'btn btn-primary me-2']) ?>
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

<?= $this->endSection() ?>
