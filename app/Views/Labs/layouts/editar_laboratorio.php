<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_laboratorio') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar laboratorio</span>
        </div>
        <div class="card-body">
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <form>
                        <div class="mb-3">
                            <label for="carrera">Carrera</label>
                            <input class="form-control form-control-solid" id="editCarrera" type="input" placeholder="Nombre de la carrera" />
                        </div>
                        <div class="mb-3">
                            <label for="laboratorio">Nombre</label>
                            <input class="form-control form-control-solid" id="editNombre" type="input" placeholder="Nombre del laboratorio" />
                        </div>
                        <!-- Botones de Guardar y Cancelar -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2">Guardar cambios</button>
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>                       
<?= $this->endSection() ?>