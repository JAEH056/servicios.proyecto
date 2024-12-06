<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Affiliate Dashboard - SB Admin Pro</title>
    <link href="<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <?= $this->include('dashboard/navbar_dashboard') ?>
    <div>
        <div id="layoutSidenav_content" class="mt-10">
            <main>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-5">
                    <div class="row">
                        <!-- Mensaje de error de filter -->
                        <?php if (session()->has('message')): ?>
                            <div class="alert alert-danger"> <?= session('message') ?> </div>
                        <?php endif; ?>
                        <!-- Mensaje de insert en el primer login -->
                        <?php if (session()->has('notification')): ?>
                            <div class="alert alert-danger"> <?= session('notification') ?> </div>
                        <?php endif; ?>
                         <!-- Mensaje de insert en el primer login -->
                         <?php if (session()->has('auth_message')): ?>
                            <div class="alert alert-danger"> <?= session('auth_message') ?> </div>
                        <?php endif; ?>
                        <!-- Primera tarjeta REPOSS -->
                        <div class="col-lg-3 mb-4">
                            <div class="card mb-4">
                                <div class="card-body text-center p-5">
                                    <img class="img-fluid mb-5" width="200px" height="200px" src="<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
                                    <h4>Residencias Profesionales (Alumnos)</h4>
                                    <p class="d-inline-flex gap-1">
                                        <a href="<?= base_url('usuario/residentes/home') ?>" class="btn btn-primary">Ingresar</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Primera tarjeta REPOSS -->
                        <div class="col-lg-3 mb-4">
                            <div class="card mb-4">
                                <div class="card-body text-center p-5">
                                    <img class="img-fluid mb-5" width="200px" height="200px" src="<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
                                    <h4>Residencias Profesionales (DRPSS)</h4>
                                    <p class="d-inline-flex gap-1">
                                        <a href="<?= base_url('usuario/drpss/inicio') ?>" class="btn btn-primary">Ingresar</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Segunda tarjeta LABSS -->
                        <div class="col-lg-3 mb-4">
                            <div class="card mb-4">
                                <div class="card-body text-center p-5">
                                    <img class="img-fluid mb-5" width="200px" height="200px" src="<?= base_url("resources/assets/img/flores.jpg") ?>" />
                                    <h4>Gestión de laboratorios (LABS)</h4>
                                    <p class="mb-4">Sistema de Sara y Vianey</p>
                                    <a class="btn btn-primary p-3" href="#!">Ingresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <?= $this->include('dashboard/footer') ?>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url("resources/js/scripts.js") ?>"></script>
</body>

</html>