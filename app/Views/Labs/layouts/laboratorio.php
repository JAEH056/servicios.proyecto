<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('include_javascript') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content_laboratorio') ?>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <span>Laboratorios</span>
                <button class="btn btn-primary ms-auto" type="button" onclick="window.location.href='<?= base_url('laboratorio/nuevo') ?>'">
                    <i class="fa-solid fa-plus me-2"></i>Agregar
                </button>
            </div>
            <div class="card-body">
                <?php if (!empty($laboratorios)): ?> 
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
                        <?php foreach ($laboratorios as $datos_laboratorios): ?>
                        <tr>
                            <td><?= esc($datos_laboratorios['carrera_nombre']) ?></td>
                            <td><?= esc($datos_laboratorios['nombre_laboratorio']) ?></td>
                            <td>
                                <!-- Botón Editar -->
                                <button class="btn btn-warning" type="button" onclick="editForm(<?= $datos_laboratorios['id'] ?>)">
                                    <i class="fa-solid fa-pencil me-2"></i>Editar
                                </button>
                            </td>
                            <td>
                                <!-- Botón Eliminar -->
                                <button class="btn btn-danger" type="button" onclick="confirmDelete(<?= $datos_laboratorios['id'] ?>)">
                                    <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?> 
                    <p>No hay laboratorios disponibles.</p>
                <?php endif; ?> 
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('inline_javascript') ?>
    <script>
        // Función para redirigir a la edición
        function editForm(id) {
            window.location.href = `<?= base_url('laboratorios/editar/') ?>${id}`;
        }

        // Confirmar eliminación
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este laboratorio?')) {
                window.location.href = `<?= base_url('laboratorios/eliminar/') ?>${id}`;
            }
        }
    </script>
<?= $this->endSection() ?>
