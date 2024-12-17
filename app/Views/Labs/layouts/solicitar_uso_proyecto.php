<?= $this->extend('Labs/layouts/principal_laboratorista') ?>
<?= $this->section('content_solicitar_uso_proyecto') ?>
<!-- Solid Form Controls-->
<div id="solid" class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <span>Solicitar uso proyecto</span>
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
                            <label for="exampleFormControlSelect1">Tipo de uso</label>
                            <select class="form-control form-control-solid" id="exampleFormControlSelect1">
                                <option>Proyecto</option>
                                <option>Actividad</option>
                                <option>Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Nombre...</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="email" placeholder="Nombre..." />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2">Descripción de las tareas que se realizarán</label>
                            <input class="form-control form-control-solid" id="exampleFormControlInput2" type="text" placeholder="Descripción de las tareas que se realizarán" />
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