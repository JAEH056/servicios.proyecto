<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('Reposs/MenusResidente/inicioResidente'); ?>

<?= $this->section('contenido'); ?>
<style>
    .list-group-item {
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transition */
    }

    .list-group-item:hover {
        background-color: rgb(145, 148, 151);
        /* Change to your desired hover color */
        color: white;
        /* Change text color on hover */
        cursor: pointer;
        /* Change cursor to pointer */
    }
</style>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="overview-tab" href="<?= base_url('/usuario/residentes/empresa') ?>" aria-selected="false">Datos de Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="overview-tab" href="<?= base_url('/usuario/residentes/empresa') ?>" aria-selected="false">Agregar Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="example-tab" href="#asesorexterno" data-bs-toggle="tab" role="tab" aria-controls="asesorexterno" aria-selected="true">Asesor Externo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#carta" data-bs-toggle="tab" role="tab" aria-controls="carta" aria-selected="false">Descargar Carta</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="asesorexterno" role="tabpanel" aria-labelledby="asesorexterno-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <!-- Envia la lista de errores al formulario -->
                                <?php if (session()->getFlashdata('error') !== null): ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('mensaje') !== null): ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('mensaje'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Envia la lista de errores al formulario -->
                                <h5 class="card-title">Datos de Asesor Externo</h5>
                                <p>Ingresa los datos solicitados. Esta información se utilizará posteriormente para completar los formatos necesarios en el proceso de residencias profesionales.</p>
                                <p>Busca los datos del asesor usando el nombre como parametro de busqueda.</p>
                                <div class="row gx-3 mb-3">
                                    <form id="searchForm">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre completo" aria-label="Buscar">
                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="mb-3">
                                    <ul id="results" class="list-group mt-3"></ul>
                                </div>
                                <form action="<?= base_url('usuario/residentes/asesor-externo') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <!-- Form Group (Asesor Externo)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="empresa_asesor">Empresa del Asesor</label>
                                        <?php if (empty($datosEmpresa['nombre_empresa']) == true): ?>
                                            <label class="form-control">Agrega una nueva empresa.</label>
                                        <?php else: ?>
                                            <select class="form-control" id="idempresa" name="idempresa">
                                                <?php foreach ($listaEmpresas as $empresa): ?>
                                                    <option value="<?= $empresa['idempresa'] ?>"><?= $empresa['nombre_empresa'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="cargo">Cargo</label>
                                            <input class="form-control" id="cargo" type="text"
                                                placeholder="Cargo del asesor" name="cargo" />
                                        </div>
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="puesto">Puesto</label>
                                            <input class="form-control" id="puesto" type="text"
                                                placeholder="Puesto del asesor" name="puesto" />
                                        </div>
                                        <!-- Form Group (Grado Academico)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="grado">Grado Academico</label>
                                            <input class="form-control" id="grado" type="text"
                                                placeholder="Grado academico ej.: Lic. ISC. MA. etc." name="grado" />
                                        </div>
                                        <!-- Form Group (Nombre Titular)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" type="text"
                                                placeholder="Ingresa el nombre(s) del asesor" name="nombre" />
                                        </div>
                                        <!-- Form Group (Primer Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text"
                                                placeholder="Ingresa el primer apellido" name="apellido1" />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text"
                                                placeholder="Ingresa el segundo apellido" name="apellido2" />
                                        </div>
                                        <!-- Form Group (email asesor)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="correo_asesor_ext">Correo del asesor</label>
                                            <input class="form-control" id="correo_asesor_ext" name="correo" type="email" placeholder="Ingresa el correo del asesor" />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="telefono">Telefono Asesor</label>
                                            <input class="form-control" id="telefono" type="text"
                                                placeholder="Ingresa el telefono del asesor" name="telefono" />
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Agregar Asesor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="carta" role="tabpanel" aria-labelledby="carta-tab">
                        <h5 class="card-title">Resumen de Información.</h5>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nombre)-->
                            <div class="mb-3">
                                <!-- Informacion extra  -->
                            </div>
                            <table>
                                <thead>
                                    <th>Nombre del Formato</th>
                                    <th>Información requerida</th>
                                    <th>Acción</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Informal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a> y de la <a href="<?= base_url('/usuario/residentes/empresa') ?>">empresa</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                    <tr>
                                        <td><i data-feather="file-text"></i>Carta Formal</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a>, de la <a href="<?= base_url('/usuario/residentes/empresa') ?>">empresa</a> y agregar informacion del <a href="<?= base_url('/usuario/residentes/empresa_asesor_externo') ?>">Asesor Externo</a>.</td>
                                        <td><button class="btn btn-primary">Descargar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchInput = document.getElementById('searchInput').value;

        fetch(`<?= base_url('usuario/residentes/asesor_interno/busqueda') ?>?nombre=${encodeURIComponent(searchInput)}`)
            .then(response => response.json())
            .then(data => {
                const results = document.getElementById('results');
                results.innerHTML = '';
                data.forEach(asesor => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = `${asesor.nombre} ${asesor.apellido1} ${asesor.apellido2}`;
                    li.onclick = () => llenarFormulario(asesor);
                    results.appendChild(li);
                });
            }).catch(error => console.error('Error fetching data:', error));
    });

    function llenarFormulario(asesor) {
        document.getElementById('cargo').value = asesor.cargo;
        document.getElementById('correo_asesor_ext').value = asesor.principal_name;
        document.getElementById('nombre').value = asesor.nombre;
        document.getElementById('apellido1').value = asesor.apellido1;
        document.getElementById('apellido2').value = asesor.apellido2;
    }
</script>
<?= $this->endSection(); ?>