<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_horario') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Horarios</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location.href='<?= base_url('horario/nuevo') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Laboratorio</th>
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mostrar horarios -->
                        <?php if(!empty($horarios)): ?>
                        <?php foreach ($horarios as $datos_horarios): ?>
                        <tr>
                            <td><?= esc($datos_horarios['nombre_semestre']) ?></td>
                            <td><?= esc($datos_horarios['nombre_laboratorio']) ?></td>
                            <td>
                                <!-- Botón Editar -->
                                <button class="btn btn-teal" type="button" onclick="window.location = '<?= site_url('laboratorio/editar/'.  $datos_horarios['id']) ?>'">
                                    <i class="fa-solid fa-eye me-2"></i>Ver
                                </button>
                            </td>
                            <td>
                                <!-- Botón Editar -->
                                <button class="btn btn-warning" type="button" onclick="window.location = '<?= site_url('laboratorio/editar/'.  $datos_horarios['id']) ?>'">
                                    <i class="fa-solid fa-pencil me-2"></i>Editar
                                </button>
                            </td>
                            <td>
                                <!-- Botón Eliminar -->
                                <button class="btn btn-danger" type="button" onclick="confirmDelete(<?= esc($datos_horarios['id']) ?>)">
                                    <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?> 
                        <tr>
                            <td colspan="6" class="text-center">No hay horarios registrados.</td>
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
                window.location.href = '<?= site_url('horario/eliminar/') ?>' + id;
            }
        }
    </script>
<?= $this->endSection() ?>
