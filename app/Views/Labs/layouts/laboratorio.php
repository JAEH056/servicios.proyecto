<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src= "<?=base_url("resources/js/datatables/datatables-simple-demo.js") ?>" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content_laboratorio') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Laboratorios</span>
                <button class="btn btn-primary ms-auto" type="button"><i class="fa-solid fa-plus me-2"></i>Agregar</button>
            </div>
            <div class="card-body">
                <?php
                    if(!empty($lista_laboratorios)){ 
                ?>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Carrera</th>
                            <th>Nombre</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- MOSTRAR LABORATORIOS -->
                        <?php
                            foreach($lista_laboratorios as $datos_laboratorios){ ?>
                        <tr>
                            <td><?php echo $datos_laboratorios['laboratorio']; ?></td>
                            <td><?php echo $datos_laboratorios['carrera']; ?></td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                 <button class="btn btn-warning" type="button" onclick="editForm(<?=base_url($datos_laboratorios['id']) ?>)"><i class="fa-solid fa-pencil me-2"></i>Editar</button>
                            </td>
                            <td>
                                <!-- BOTÓN ELIMINAR -->
                                <button class="btn btn-danger" type="button"><i class="fa-solid fa-trash-can me-2"></i>Eliminar</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        //Funcion Editar
        function editForm(){
            window.location.href= `<?=base_url('vista/actualizar/laboratorios') ?>${id}`;
        }
    </script>
<?= $this->endSection() ?>