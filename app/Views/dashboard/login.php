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
    <title>Login</title>
    <link href="<?= base_url("resources/css/principal.css") ?>" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center text-center">
                                    <h1 class="fw-light my-4">Servicios ITSH</h1>
                                </div>
                                <div class="card-body">
                                    <!-- Login form-->
                                    <form>
                                        <!-- Form Group (login box)-->
                                        <div class="d-flex flex-column align-items-center justify-content-between mt-4 mb-0">
                                            <img class="dropdown-notifications-item-img mb-5" width="200" height="200" src="<?= base_url("resources/assets/img/logo_ITSH.png") ?>" />
                                            <!-- <a class="small" href="auth-password-basic.html">Forgot Password?</a> -->
                                            <a class="btn btn-primary w-100" href="<?= base_url('oauth/login')?>"><img src="<?= base_url("resources/assets/img/logo_Office.png") ?>" alt="icono" width="25" height="25" class="me-2" />Microsoft365 Institucional</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <?= $this->include('dashboard/footer') ?>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url("resources/js/scripts.js") ?>"></script>
</body>

</html>