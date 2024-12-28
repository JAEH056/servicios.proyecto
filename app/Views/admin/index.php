<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="<?= base_url('/resources/css/styles.css')?>" rel="stylesheet" />

    <!-- Bootstrap JavaScript (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Bootstrap Modal -->
    <!-- div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div -->
    <div class="container mt-5">
        <h1 class="mb-4">Panel de Administración</h1>

        <!-- Mensajes de éxito o error -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Crear Rol -->
        <h2>Gestión de Roles</h2>
        <form method="post" action="/admin/createRole">
            <div class="mb-3">
                <label for="role_name" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" id="role_name" name="role_name" required>
            </div>
            <div class="mb-3">
                <label for="role_description" class="form-label">Descripción del Rol</label>
                <input type="text" class="form-control" id="role_description" name="role_description" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Rol</button>
        </form>

        <!-- Listar Roles -->
        <h3 class="mt-4">Roles Existentes</h3>
        <ul class="list-group" id="roles-list">
            <?php foreach ($roles as $role): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $role['Title'] ?> (<?= $role['Description'] ?>)
                    <button
                        class="btn btn-danger btn-sm delete-button"
                        data-id="<?= $role['ID'] ?>"
                        data-type="role">
                        Delete
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Listar roles asignados-->
        <h3>Permisos Asignados a Roles</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Role ID</th>
                    <th>Role Name</th>
                    <th>Permission ID</th>
                    <th>Permission Name</th>
                    <th>Assignment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rolePermissions as $rp): ?>
                    <tr>
                        <td><?= $rp['RoleID'] ?></td>
                        <td><?= $rp['RoleName'] ?></td>
                        <td><?= $rp['PermissionID'] ?></td>
                        <td><?= $rp['PermissionName'] ?></td>
                        <td><?= date('Y-m-d', $rp['AssignmentDate']) ?></td>
                        <td>
                            <button
                                class="btn btn-danger btn-sm delete-button"
                                data-id="<?= $rp['RoleID'] . '-' . $rp['PermissionID'] ?>"
                                data-type="role-permission">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Crear Permiso -->
        <h2 class="mt-5">Gestión de Permisos</h2>
        <form method="post" action="/admin/createPermission">
            <div class="mb-3">
                <label for="permission_name" class="form-label">Nombre del Permiso</label>
                <input type="text" class="form-control" id="permission_name" name="permission_name" required>
            </div>
            <div class="mb-3">
                <label for="permission_description" class="form-label">Descripción del Permiso</label>
                <input type="text" class="form-control" id="permission_description" name="permission_description" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Permiso</button>
        </form>

        <!-- Asignar Permiso a Rol -->
        <h2 class="mt-5">Asignar Permisos a Roles</h2>
        <form method="post" action="/admin/assignPermissionToRole">
            <div class="mb-3">
                <label for="role_id" class="form-label">Selecciona un Rol</label>
                <select class="form-control" id="role_id" name="role_id">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['ID'] ?>"><?= $role['Title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="permission_id" class="form-label">Selecciona un Permiso</label>
                <select class="form-control" id="permission_id" name="permission_id">
                    <?php foreach ($permissions as $permission): ?>
                        <option value="<?= $permission['ID'] ?>"><?= $permission['Title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Asignar Permiso</button>
        </form>
    </div>
    <div class="container">
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!">Privacy Policy</a>
                        &middot;
                        <a href="#!">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

<script>
    // Script AJAX para manejo de eliminacion de Roles y Permisos asignados a roles
    document.addEventListener('DOMContentLoaded', function() {
        // Se inicializan las variables de Tipo de eliminacion y el ID eliminado(Roles)
        let currentDeleteType = null;
        let currentDeleteId = null;
        // Event listener for delete buttons // Funcion de escucha para los botones de eliminar
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                currentDeleteType = this.getAttribute('data-type');
                currentDeleteId = this.getAttribute('data-id');

                // Show the modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

        // Handle delete confirmation  //Ejercisio para realizar la eliminacion
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (currentDeleteType && currentDeleteId) {
                let endpoint = '';
                let payload = {};

                // Determine the endpoint and payload based on the type
                // Se determina la informacion entregada y el curso a seguir basado en el tipo de accion
                if (currentDeleteType === 'role') {
                    endpoint = '/admin/deleteRole';
                    payload = {
                        role_id: currentDeleteId
                    };
                } else if (currentDeleteType === 'role-permission') {
                    endpoint = '/admin/deleteRolePermission';
                    const [roleId, permissionId] = currentDeleteId.split('-');
                    endpoint = '/admin/deleteRolePermission';
                    payload = {
                        role_id: roleId,
                        permission_id: permissionId
                    };
                }

                // Send the AJAX request // Se envia la solicitud AJAX
                fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the corresponding row or item // Se elimina la fila eliminada
                            if (currentDeleteType === 'role') {
                                document.querySelector(`#roles-list [data-id="${currentDeleteId}"]`).closest('li').remove();
                            } else if (currentDeleteType === 'role-permission') {
                                document.querySelector(`[data-id="${currentDeleteId}"]`).closest('tr').remove();
                            }
                            alert(data.message);
                        } else {
                            alert(data.message || 'Failed to delete the item.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the item.');
                    });
            }

            // Hide the modal  // Se oculta el MODAL
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();
        });
    });
</script>

<script>
    // Add event listener to the delete button
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listeners to delete buttons
        document.querySelectorAll('.delete-role-permission').forEach(button => {
            button.addEventListener('click', function() {
                const roleId = this.getAttribute('data-role-id');
                const permissionId = this.getAttribute('data-permission-id');

                if (confirm('Are you sure you want to delete this assignment?')) {
                    fetch('/admin/deleteRolePermission', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                role_id: roleId,
                                permission_id: permissionId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the corresponding table row
                                const row = document.getElementById(`row-${roleId}-${permissionId}`);
                                if (row) row.remove();
                                alert(data.message);
                            } else {
                                alert(data.message || 'Failed to delete the assignment.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the assignment.');
                        });
                }
            });
        });
    });
</script>

<script>
    // Event listener for modal show
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const roleName = button.getAttribute('data-role'); // Extract role name
        const deleteUrl = button.getAttribute('data-url'); // Extract delete URL

        // Update modal content
        const roleNameSpan = deleteModal.querySelector('#roleName');
        const confirmDeleteButton = deleteModal.querySelector('#confirmDeleteButton');

        roleNameSpan.textContent = roleName;
        confirmDeleteButton.setAttribute('href', deleteUrl);
    });
</script>

</html>