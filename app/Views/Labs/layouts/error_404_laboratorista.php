<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->section('content_error_404_laboratorista') ?>
<body class="bg-white">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                            <p><?= esc($mensaje) ?></p>
                                <img class="img-fluid p-4" src="<?= base_url('resources/assets/img/illustrations/404-error-with-a-cute-animal.svg') ?>" alt="404 Error"/>
                                <p class="lead">LABORATORISTA.</p>
                                <a class="text-arrow-icon" href="dashboard-1.html">
                                    <i class="ms-0 me-1" data-feather="arrow-left"></i>
                                    Return to Dashboard
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<?= $this->endSection() ?>

<body class="bg-white">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="img-fluid p-4" src="assets/img/illustrations/404-error.svg" alt="" />
                                <p class="lead">This requested URL was not found on this server.</p>
                                <a class="text-arrow-icon" href="dashboard-1.html">
                                    <i class="ms-0 me-1" data-feather="arrow-left"></i>
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
