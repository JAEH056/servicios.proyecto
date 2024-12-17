<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_solicitar_uso_practica') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Solicitar uso práctica</span>
        </div>
        <div class="card-body">
            <!-- Component Preview-->
            <div class="sbp-preview">
                <div class="sbp-preview-content">
                    <form>
                        <div class="mb-3">
                            <label for="exampleFormControlDate">Fecha</label>
                            <input class="form-control form-control-solid" id="exampleFormControlDate" type="date" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Nombre del laboratorio</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput1" type="email" placeholder="Nombre del laboratorio" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Clave de la asignatura</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Clave de la asignatura" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Nombre de la asignatura</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Nombre de la asignatura" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Grupo</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Grupo" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Nombre de la práctica</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Nombre de la práctica" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Objetivo/Competencia de la práctica</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Objetivo/Competencia de la práctica" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Hora de entrada</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="time" placeholder="Hora de entrada" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Hora de salida</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="time" placeholder="Hora de salida" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Nombre del docente</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Nombre del docente" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Número de estudiantes a participar</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Número de estudiantes a participar" />
                        </div>
                        <!-- <div class="mb-3">
                            <label for="exampleFormControlDate">Fecha de inicio</label>
                            <input class="form-control form-control-solid" id="exampleFormControlDate" type="date" />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlDate">Fecha de fin</label>
                            <input class="form-control form-control-solid" id="exampleFormControlDate" type="date" />
                        </div> -->

                        <!-- Botones de Guardar y Cancelar -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Solicitar</button>
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>                       
<?= $this->endSection() ?>