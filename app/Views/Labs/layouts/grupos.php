<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src= "<?=base_url("resources/js/datatables/datatables-simple-demo.js") ?>" ></script>
<?= $this->endSection() ?>

<?= $this->section('content_grupos') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">

                <span>Dias inhábiles</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location = '<?= site_url('diasinhabiles/nuevo') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tipo</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- MOSTRAR DIAS -->
                        <?php if(!empty($dias)): ?>
                            <?php foreach($dias as $dia): ?>
                                <tr>
                                    <td><?= esc($dia['nombre'])?></td>
                                    <td><?= esc($dia['tipo_inhabil'])?></td>
                                    <td><?= esc($dia['inicio'])?></td>
                                    <td><?= esc($dia['fin'])?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" type="button" onclick="window.location = '<?= site_url('diasinhabiles/editar/'. $dia['id']) ?>'">
                                            <i class="fa-solid fa-pencil me-2"></i>Editar
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" type="button" onclick="confirmDelete(<?= esc($dia['id']) ?>)">
                                            <i class="fa-solid fa-trash-can me-2"></i>Eliminar</button>
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
    function confirmDelete(id) {
        // Mostrar la alerta de confirmación
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            // Si el usuario confirma, redirigir a la URL de eliminación
            window.location.href = '<?= site_url('diasinhabiles/eliminar/') ?>' + id;
        }
    }
</script>
<?= $this->endSection() ?>