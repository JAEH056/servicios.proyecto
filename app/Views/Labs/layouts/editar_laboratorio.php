<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_laboratorio') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar laboratorio</span>
        </div>
        <div class="card-body">
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <!-- Abrir formulario con Form Helper -->
                     
                    <?= form_open('usuario/actualizar/laboratorio/' .esc($laboratorio['id']), ['id' => 'fomr-laboratorio']) ?>
                    <?= csrf_field() ?>
                    <?php $errors = session('errors'); ?>
                    <!-- Nombre del laboratorio -->
                    <div class="mb-3">
                        <?= form_label('Nombre del laboratorio', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'nombre',
                            'id' => 'nombre',
                            'type' => 'text',
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Nombre del laboratorio',
                            'value' => set_value('nombre', $laboratorio['nombre'] ?? null),
                        ]) ?>
                         <?php if (isset($errors['nombre'])): ?>
                            <span class="text-danger"><?= $errors['nombre'] ?></span>
                        <?php endif; ?>
                    </div>
                  
                    <!-- Selector carrera -->
                    <div class="mb-3">
                        <?= form_label('Carrera', 'carrera', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'id_carrera',
                            [''=>'Seleccionar carrera'] + array_column($carrera, 'nombre_carrera', 'id'),
                            set_value('id_carrera',$laboratorio['id_carrera'] ?? null),
                            ['id' => 'id_carrera', 'class' => 'form-control form-control-solid']
                        ) ?>
                             <?php if (isset($errors['id_carrera'])): ?>
                            <span class="text-danger"><?= $errors['id_carrera'] ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Botones de Guardar y Cancelar -->
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
<?= $this->endSection() ?>