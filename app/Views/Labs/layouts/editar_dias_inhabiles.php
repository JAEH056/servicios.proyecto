<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_dias_inhabiles') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar días inhábiles</span>
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
                    <?= form_open('dias_inhabiles/actualizar/' .esc($dia['id']))?>
                        <?= csrf_field() ?>

                        <!-- Campo Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input 
                                type="text" 
                                name="nombre" 
                                id="nombre" 
                                value="<?= set_value('nombre',$dia['descripcion'] ?? null) ?>" 
                                class="form-control form-control-solid" 
                                maxlength="255">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('nombre') : '' ?></span>
                        </div>

                        <!-- Campo Tipo Inhabil -->
                        <div class="mb-3">
                            <label for="tipo_inhabil" class="form-label">Tipo</label>
                            <select 
                                name="tipo_inhabil" 
                                id="tipo_inhabil" 
                                class="form-control form-control-solid">
                                <option value="">Seleccionar tipo</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option 
                                        value="<?= $tipo['id'] ?>" 
                                        <?= set_value('tipo_inhabil', $dia['id_tipo_inhabil']) == $tipo['id'] ? 'selected' : '' ?>>
                                        <?= $tipo['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('tipo_inhabil') : '' ?></span>
                        </div>

                        <!-- Campo Fecha de Inicio -->
                        <div class="mb-3">
                            <label for="inicio" class="form-label">Fecha de inicio</label>
                            <input 
                                type="date" 
                                name="inicio" 
                                id="inicio" 
                                value="<?= set_value('inicio', $dia['inicio']) ?>" 
                                class="form-control form-control-solid">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('inicio') : '' ?></span>
                        </div>

                        <!-- Campo Fecha de Fin -->
                        <div class="mb-3">
                            <label for="fin" class="form-label">Fecha de fin</label>
                            <input 
                                type="date" 
                                name="fin" 
                                id="fin" 
                                value="<?= set_value('fin', $dia['fin']) ?>" 
                                class="form-control form-control-solid">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('fin') : '' ?></span>
                        </div>

                        <!-- Botones Guardar y Cancelar -->
                        <div class="mt-3 d-flex justify-content-end">
                            <?= form_submit('submit', 'Guardar', ['class' => 'btn btn-primary me-2']) ?>
                            <?= form_button('cancel', 'Regresar', [
                                'type' => 'button',
                                'class' => 'btn btn-secondary',
                                'onclick' => 'history.back()',
                                ])
                            ?>
                        </div>
                    </div>
                    <?= form_close()?>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
