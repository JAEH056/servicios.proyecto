<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_laboratorista') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Laboratoristas</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location = '<?= site_url('laboratorista/mostrar') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nombre del laboratorio</th>
                            <th>Nombre del encargado</th>
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mostrar semestres -->
                        <?php if(!empty($laboratoriosEncargado)): ?>
                        <?php foreach ($laboratoriosEncargado as $datos_laboratoristas): ?>         
                        <tr>
                            <td><?= esc($datos_laboratoristas['nombre_laboratorio'])?></td>
                            <td><?= esc($datos_laboratoristas['encargado'])?></td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                <button class="btn btn-sm btn-teal" type="button">
                                    <i class="fa-solid fa-eye me-2"></i>Ver
                                </button>
                            </td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                 <button class="btn btn-sm btn-warning" type="button">
                                    <i class="fa-solid fa-pencil me-2"></i>Editar
                                </button>
                            </td>
                            <td>
                                <!-- BOTÓN ELIMINAR -->
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                                </button>
                            </td>

                            
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
<script>
    function confirmDelete(id) {
        // Mostrar la alerta de confirmación
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            // Si el usuario confirma, redirigir a la URL de eliminación
            window.location.href = '<?= site_url('semestre/eliminar/') ?>' + id;
        }
    }
</script>
<?= $this->endSection() ?>
