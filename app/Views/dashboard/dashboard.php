<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Affiliate Dashboard - SB Admin Pro</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href= "<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href= "<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">
        <?= $this->include('dashboard/navbar') ?>
        <div>
            <div id="layoutSidenav_content" class="mt-10">
                <main>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-5">
                        <div class="row">
                            <!-- Primera tarjeta REPOSS -->
                            <div class="col-lg-6 mb-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center p-5">
                                        <img class="img-fluid mb-5" width="85%" height="85%" src= "<?= base_url("resources/assets/img/flores.jpg") ?>" />
                                        <h4>Residencias profesionales (REPOSS)</h4>
                                        <p class="mb-4">Sistema de Estudillo</p>
                                        <a class="btn btn-primary p-3" href="#!">Ingresar</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Segunda tarjeta LABSS -->
                            <div class="col-lg-6 mb-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center p-5">
                                        <img class="img-fluid mb-5" width="85%" height="85%" src= "<?= base_url("resources/assets/img/flores.jpg") ?>" />
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
        <script src= "<?= base_url("resoruces/js/scripts.js") ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
    </body>

</html>
