<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('content_agregar_dias_inhabiles') ?>
<div id="solid" class="container-xl px-4 mt-n5">
    <div class="card mb-4">
        <div class="card-header">
            <span>Agregar días inhábiles</span>
        </div>
        <div class="card-body">
            <!-- MENSAJE DE EXITO O ERROR -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?= $success; ?>
                </div>
            <?php endif; ?>

            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <?= form_open('dias_inhabiles/crear', ['id' => 'form-dias-inhabiles']) ?> 
                    <?= csrf_field() ?>

                    <!-- Campo Nombre -->
                    <div class="mb-3">
                        <?= form_label('Nombre', 'nombre', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'nombre',
                            'id' => 'nombre',
                            'type' => 'text',
                            'value' => set_value('nombre'),
                            'class' => 'form-control form-control-solid',
                            'maxlength' => '255',
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('nombre') : '' ?></span>
                    </div>

                    <!-- Campo Tipo Inhabil -->
                    <div class="mb-3">
                        <?= form_label('Tipo', 'tipo_inhabil', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'tipo_inhabil',
                            ['' => 'Seleccionar tipo'] + array_column($tiposdia, 'nombre', 'id'),
                            set_value('tipo_inhabil'),
                            ['id' => 'tipo_inhabil', 'class' => 'form-control form-control-solid']
                        ) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('tipo_inhabil') : '' ?></span>
                    </div>

                    <!-- Campo Fecha de Inicio -->
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

                    <!-- Campo Fecha de Fin -->
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

                    <!-- Botones Guardar y Cancelar -->
                    <div class="mt-3 d-flex justify-content-end">
                        <?= form_submit('submit', 'Guardar', ['class' => 'btn btn-primary me-2']) ?>
                        <?= form_button('cancel', 'Cancelar', [
                            'type' => 'button',
                            'class' => 'btn btn-secondary',
                            'onclick' => "window.location.href='" .base_url('diasinhabiles'). "'",
                        ]) ?>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>