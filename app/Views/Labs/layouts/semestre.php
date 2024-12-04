<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content_semestre') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Semestres</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location ='<?= site_url('semestre/nuevo') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <?php if (!empty($semestre)): ?>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- MOSTRAR SEMESTRE -->
                        <?php foreach ($semestre as $datos_semestre): ?>         
                        <tr>
                            <td><?= esc($datos_semestre['nombre']) ?></td>
                            <td><?= esc($datos_semestre['inicio']) ?></td>
                            <td><?= esc($datos_semestre['fin']) ?></td>
                            <td>
                                <!-- BOTÓN EDITAR -->
                                 <button class="btn btn-sm btn-warning" type="button" onclick="window.location = '<?= site_url('semestre/editar/'. $datos_semestre['id']) ?>'"><i class="fa-solid fa-pencil me-2"></i>Editar</button>
                            </td>
                            <td>
                                <!-- BOTÓN ELIMINAR -->
                                <button class="btn btn-sm btn-danger" type="button" onclick="confirmDelete(<?= esc($datos_semestre['id']) ?>)"><i class="fa-solid fa-trash-can me-2"></i>Eliminar</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?> 
                <p>No hay semestres disponibles.</p>
                <?php endif; ?> 
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
