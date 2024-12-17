<?= $this->extend('Labs/layouts/principal_laboratorista') ?>

<?= $this->renderSection('content_error_404') ?>
<body class="bg-white">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="img-fluid p-4" src="assets/img/illustrations/400-error-bad-request.svg" alt="" />
                                <p class="lead">Your client has issued a malformed or illegal request.</p>
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
            <footer class="footer-admin mt-auto footer-light">
                <?= $this->include('dashboard/footer') ?>
            </footer>
    </div>
</body>
<?= $this->endSection() ?>