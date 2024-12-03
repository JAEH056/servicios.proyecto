<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Panel Administrativo</title>
    <link href="<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('resources/assets/img/logo_ITSH.png') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <!--Se incluye el Top nav principal-->
    <?= $this->include('Reposs/Plantilla/mainTopnav'); ?>
    <!-- Bootstrap Modal -->
    <?= $this->include('Reposs/Plantilla/adminModal'); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Reposs/Plantilla/mainSidenav') ?>
        </div>
        <!-- Contenido Principal -->
        <div id="layoutSidenav_content">
            <main>
                <?= $this->include('Reposs/Plantilla/mainHeader'); ?>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-n10">
                    <!-- Contenido de alerta -->
                    <div class="card mb-4">
                        <div class="card-header">Alerta</div>
                        <div class="card-body">
                            Contenido principal
                            <!-- Mensajes de éxito o error -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Crear Rol -->
                    <div class="card mb-4">
                        <div class="card-header">Gestión de Roles</div>
                        <div class="card-body">
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
                        </div>
                    </div>
                    <!-- Crear Permiso -->
                    <div class="card mb-4">
                        <div class="card-header">Gestión de Permisos</div>
                        <div class="card-body">
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
                        </div>
                    </div>
                    <!-- Listar Roles -->
                    <div class="card mb-4">
                        <div class="card-header">Roles Existentes</div>
                        <div class="card-body">
                            <ul class="list-group" id="roles-list">
                                <?php foreach ($roles as $role): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $role['Title'] ?> (<?= $role['Description'] ?>)
                                        <button
                                            class="btn btn-danger btn-sm delete-button"
                                            data-id="<?= $role['ID'] ?>"
                                            data-type="role">
                                            Eliminar
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Asignar Permisos a Rol -->
                    <div class="card mb-4">
                        <div class="card-header">Asignar Permisos a Roles</div>
                        <div class="card-body">
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
                    </div>
                    <!-- Listar roles asignados-->
                    <div class="card mb-4">
                        <div class="card-header">Permisos Asignados a Roles</div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Rol ID</th>
                                        <th>Nombre Rol</th>
                                        <th>Permiso ID</th>
                                        <th>Descripción del Permiso</th>
                                        <th>Fecha de asignación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Role ID</th>
                                        <th>Role Name</th>
                                        <th>Permission ID</th>
                                        <th>Permission Name</th>
                                        <th>Assignment Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
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
                                                    Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('Reposs/Plantilla/mainFooter'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/scripts.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
</body>
<script src="<?= base_url('resources/js/adminpage/rolepermissionscripts.js') ?>"></script>
<script src="<?= base_url('resources/js/adminpage/rolescripts.js') ?>"></script>
<script src="<?= base_url('resources/js/adminpage/modalscripts.js') ?>"></script>
</html>