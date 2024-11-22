<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title??'' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url("Labs/resources/assets/img/favicon.png") ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?= base_url("Labs/resources/css/styles.css") ?>" rel="stylesheet" />
<?= $this->renderSection('include_css') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous" data-search-pseudo-elements defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url("Labs/resources/js/scripts.js") ?>"></script>
<?= $this->renderSection('include_javascript') ?>
</head>
<body class="nav-fixed">
    <?= $this->include('Labs/layouts/navbar') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Labs/layouts/menu') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4">
                    <?= $this->include('Labs/layouts/header') ?>
                </header>
                <!-- CONTENIDO DE LA PAGINA -->
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <?= $this->include('Labs/layouts/footer') ?>
            </footer>
        </div>
    </div>
<?= $this->renderSection('inline_javascript') ?>
</body>
</html>