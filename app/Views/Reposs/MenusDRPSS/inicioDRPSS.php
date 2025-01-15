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
    <title>Residencias Profesionales</title>
    <link href="<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('resources/assets/img/logo_ITSH.png') ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <!--Se incluye el Top nav principal-->
    <?= $this->include('Reposs/Plantilla/mainTopnavDRPSS'); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Reposs/Plantilla/mainSidenavDRPSS') ?>
        </div>
        <!-- Contenido Principal -->
        <div id="layoutSidenav_content">
            <main>
                <!-- Main page content-->
                <?= $this->renderSection('contenido'); ?>
            </main>
            <?= $this->include('Reposs/Plantilla/mainFooter'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/scripts.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('resources/js/datatables/datatables-simple-demo.js') ?>"></script>
</body>

</html>