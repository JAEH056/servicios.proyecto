<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_laboratorio') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Laboratorios</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location.href='<?= base_url('laboratorio/nuevo') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Carrera</th>
                            <th>Nombre del laboratorio</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mostrar laboratorios -->
                        <?php if(!empty($laboratorios)): ?>
                        <?php foreach ($laboratorios as $datos_laboratorios): ?>
                        <tr>
                            <td><?= esc($datos_laboratorios['carrera_nombre']) ?></td>
                            <td><?= esc($datos_laboratorios['nombre_laboratorio']) ?></td>
                            <td>
                                <!-- Botón Editar -->
                                <button class="btn btn-warning" type="button" onclick="window.location = '<?= site_url('laboratorio/editar/'.  $datos_laboratorios['id']) ?>'">
                                    <i class="fa-solid fa-pencil me-2"></i>Editar
                                </button>
                            </td>
                            <td>
                                <!-- Botón Eliminar -->
                                <button class="btn btn-danger" type="button" onclick="confirmDelete(<?= esc($datos_laboratorios['id']) ?>)">
                                    <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?> 
                        <tr>
                            <td colspan="6" class="text-center">No hay días inhábiles registrados.</td>
                        </tr>
                    <?php endif; ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        function confirmDelete(id){
            //Mostrar la alerta de confirmación
            if(confirm("¿Estás seguro de que deseas eliminar este registro?")){
                //Si el usuario confirma, redirigir a la URL  de elimación
                window.location.href = '<?= site_url('laboratorio/eliminar/') ?>' + id;
            }
        }
    </script>
<?= $this->endSection() ?>
