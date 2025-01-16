<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_semestre') ?>

<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar semestre</span>
        </div>
        <div class="card-body">
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <?= form_open('/usuario/actualizar/semestre/' .esc($semestre['id']), ['id' => 'form-semestre']) ?>
                    <?= csrf_field() ?>
                       <?php $errors = session('errors'); ?>

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
                         <?php if (isset($errors['nombre'])): ?>
                            <span class="text-danger"><?= $errors['nombre'] ?></span>
                        <?php endif; ?>
                    </div>
                   

                    <div class="mb-3">
                        <?= form_label('Fecha de inicio', 'inicio', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'inicio',
                            'id' => 'inicio',
                            'class' => 'form-control form-control-solid',
                            'type' => 'date',
                            'value' => set_value('inicio', $semestre['inicio'] ?? null),
                        ]) ?>
                         <?php if (isset($errors['inicio'])): ?>
                            <span class="text-danger"><?= $errors['inicio'] ?></span>
                        <?php endif; ?>
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
                         <?php if (isset($errors['fin'])): ?>
                            <span class="text-danger"><?= $errors['fin'] ?></span>
                        <?php endif; ?>
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
                         <?php if (isset($errors['estado'])): ?>
                            <span class="text-danger"><?= $errors['estado'] ?></span>
                        <?php endif; ?>
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
