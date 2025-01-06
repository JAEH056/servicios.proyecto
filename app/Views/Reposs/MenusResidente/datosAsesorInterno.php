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
                        <a class="nav-link" id="overview-tab" href="<?= base_url('usuario/residentes/proyecto') ?>" aria-controls="overview" aria-selected="false">Datos de Proyecto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active" id="example-tab" href="#asesorInterno" data-bs-toggle="tab" role="tab" aria-controls="example" aria-selected="false">Asesor Interno</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resume-tab" href="#solicitudResidencias" data-bs-toggle="tab" role="tab" aria-controls="download" aria-selected="false">Solicitud de Residencias</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="asesorInterno" role="tabpanel" aria-labelledby="example-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
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
                                <h5 class="card-title">Datos del Asesor Interno</h5>
                                <form method="post" action="<?= base_url('usuario/residentes/asesor-interno') ?>">
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <!-- label class="small mb-1" for="idpuesto">ID Puesto</label -->
                                            <input class="form-control" id="idpuesto" type="hidden" name="idpuesto" readonly />
                                        </div>
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="principal_name">Correo Institucional</label>
                                            <input class="form-control" id="principal_name" type="text"
                                                placeholder="Correo" name="principal_name"
                                                readonly />
                                        </div>
                                        <!-- Form Group (Puesto)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="cargo">Puesto</label>
                                            <input class="form-control" id="cargo" type="text"
                                                placeholder="Puesto del asesor" name="cargo"
                                                readonly />
                                        </div>
                                        <!-- Form Group (Grado Academico)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="grado">Grado Academico</label>
                                            <input class="form-control" id="grado" type="text"
                                                placeholder="Grado academico" name="grado"
                                                readonly />
                                        </div>
                                        <!-- Form Group (Nombre Titular)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" type="text"
                                                placeholder="Nombre(s) del asesor" name="nombre"
                                                readonly />
                                        </div>
                                        <!-- Form Group (Primer Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido1">Primer Apellido</label>
                                            <input class="form-control" id="apellido1" type="text"
                                                placeholder="Primer apellido" name="apellido1"
                                                readonly />
                                        </div>
                                        <!-- Form Group (Segundo Apellido)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="apellido2">Segundo Apellido</label>
                                            <input class="form-control" id="apellido2" type="text"
                                                placeholder="Segundo apellido" name="apellido2"
                                                readonly />
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Agregar Asesor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="solicitudResidencias" role="tabpanel" aria-labelledby="download-tab">
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
                                        <td><i data-feather="file-text"></i>Solicitud de Residencias</td>
                                        <td>Completar <a href="<?= base_url('usuario/residentes/datos') ?>">actualizar informacion personal</a> e información de la <a href="<?= base_url('usuario/residentes/empresa') ?>">empresa y asesor externo</a>.</td>
                                        <td><a class="btn btn-primary" href="<?= base_url('usuario/residentes/solicitud-residencias') ?>" target="_blank">Descargar</a></td>
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
        document.getElementById('idpuesto').value = asesor.idpuesto;
        document.getElementById('cargo').value = asesor.cargo;
        document.getElementById('principal_name').value = asesor.principal_name;
        document.getElementById('nombre').value = asesor.nombre;
        document.getElementById('apellido1').value = asesor.apellido1;
        document.getElementById('apellido2').value = asesor.apellido2;
    }
</script>
<?= $this->endSection(); ?>