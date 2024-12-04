<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_agregar_semestre') ?>

<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Agregar semestre</span>
        </div>
        <div class="card-body">
        <?php if (session()->get('success')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    alert('<?= esc(session()->get('success')) ?>');
                    window.location.href = '/semestre'; // Redirige a la página principal después del alert
                });
            </script>
        <?php endif; ?>

            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <!-- Abrir formulario con Form Helper -->
                    <?= form_open('crear') ?>
                    <?= csrf_field() ?>
                    <!-- Nombre del semestre -->
                    <div class="mb-3">
                        <?= form_label('Nombre', 'nombre') ?>
                        <?= form_input([
                            'name' => 'nombre',
                            'id' => 'nombre',
                            'type' => 'text',
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Nombre del semestre',
                            'value' => set_value('nombre')
                        ]) ?>
                    </div>
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('nombre') : '' ?></span>
                    <!-- Fecha de inicio -->
                    <div class="mb-3">
                        <?= form_label('Fecha de inicio', 'inicio') ?>
                        <?= form_input([
                            'name' => 'inicio',
                            'id' => 'inicio',
                            'class' => 'form-control form-control-solid',
                            'type' => 'date',
                            'value' => set_value('inicio')
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('inicio') : '' ?></span>
                    </div>
                    <!-- Fecha de fin -->
                    <div class="mb-3">
                        <?= form_label('Fecha de fin', 'fin') ?>
                        <?= form_input([
                            'name' => 'fin',
                            'id' => 'fin',
                            'class' => 'form-control form-control-solid',
                            'type' => 'date',
                            'value' => set_value('fin')
                        ]) ?>
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('fin') : '' ?></span>
                    </div>

                    <!-- Botones de Guardar y Cancelar -->
                    <div class="mt-3 d-flex justify-content-end">
                        <?= form_submit('submit', 'Guardar', ['class' => 'btn btn-primary me-2']) ?>
                        <a href="/semestre" class="btn btn-secondary">Regresar</a>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>                       
</div>

<?= $this->endSection() ?>
