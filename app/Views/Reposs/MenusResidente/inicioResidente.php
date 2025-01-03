<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="residencias profesionales" content="" />
    <meta name="author" content="" />
    <title>Residencias Profesionales</title>
    <link href="<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('resources/assets/img/logo_ITSH.png') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <!-- EASEPICKER -->
    <script src="https://cdn.jsdelivr.net/npm/@easepick/datetime@1.2.1/dist/index.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@easepick/base-plugin@1.2.1/dist/index.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.umd.min.js"></script>
</head>

<body class="nav-fixed">
    <!--Se incluye el Top nav principal-->
    <?= $this->include('Reposs/Plantilla/mainTopnav'); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Reposs/Plantilla/mainSidenav') ?>
        </div>
        <!-- Contenido Principal -->
        <div id="layoutSidenav_content">
            <main>
                <?= $this->include('Reposs/Plantilla/mainHeader'); ?>
                <!-- Main page content-->
                <!-- Contenido de alerta
                 <main  style="background-color : #272f3b;">
                     <div class="container-xl px-4 mt-n10">
                    <div class="card mb-4">
                        <div class="card-header">Alerta</div>
                        <div class="card-body">
                            Contenido principal
                        </div>
                    </div>
                    </div>-->
                <!-- Se incluye seccion principal -->
                <?= $this->renderSection('contenido'); ?>
            </main>
            <?= $this->include('Reposs/Plantilla/mainFooter'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/scripts.js') ?>"></script>
    <script src="<?= base_url('resources/assets/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('resources/assets/demo/chart-bar-demo.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/litepicker.js') ?>"></script>
</body>

</html>