<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_editar_semestre') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Editar semestre</span>
        </div>
        <div class="card-body">
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <form>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Nombre</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput1" type="email" placeholder="Nombre del semestre" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlDate">Fecha de inicio</label>
                            <input class="form-control form-control-solid" id="exampleFormControlDate" type="date" />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlDate">Fecha de fin</label>
                            <input class="form-control form-control-solid" id="exampleFormControlDate" type="date" />
                        </div>

                        <!-- Botones de Guardar y Cancelar -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Guardar cambios</button>
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>                       
<?= $this->endSection() ?>