<?php require_once __DIR__ . '/../../bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <title>Sign In | <?= $config->site->name; ?></title>

	    <!-- Global stylesheets -->
	    <link href="<?= $config->site->url ?>/bms/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	    <link href="<?= $config->site->url ?>/bms/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
	    <link href="<?= $config->site->url ?>/bms/assets/css/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
	    <!-- /global stylesheets -->

	    <!-- Theme JS files -->
	    <script src="<?= $config->site->url ?>/bms/assets/js/app.js"></script>
	    <!-- /theme JS files -->

    </head>

    <body class="" style="">

        <!-- Main navbar -->
        <div class="navbar navbar-dark navbar-static py-2">
            <div class="container-fluid justify-content-center align-items-center">
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item">
                        <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                            <div class="d-flex align-items-center mx-md-1">
                            <span class="d-none d-md-inline-block ms-2">Home</span>
                        </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                            <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-user-circle-plus"></i>
                            <span class="d-none d-md-inline-block ms-2">Register</span>
                        </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                            <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-user-circle"></i>
                            <span class="d-none d-md-inline-block ms-2">Login</span>
                        </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->


        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Inner content -->
                <div class="content-inner">

                    <!-- Content area -->
                    <div class="content d-flex justify-content-center align-items-center">

                        <!-- Login form -->
                        <form method="post" class="login-form" action="<?= $config->site->url ?>/bms/http/auth/sign-in/">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                            <img src="<?= $config->site->url ?>/public/assets/images/logo_icon_color.svg" style="height:6rem" alt="">
                                        </div>
                                        <h5 class="mb-0">Sign in to your account</h5>
                                        <span class="d-block text-muted">Enter your credentials below</span>
                                    </div>

                                    <input type="hidden" name="refurl" value="<?= $_GET['refurl'] ?? null ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input type="text" class="form-control" placeholder="john@doe.com" name="email" required autofocus>
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-user-circle text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input type="password" class="form-control" placeholder="•••••••••••" name="password" required>
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>

                                    <div class="text-center">
                                        <a href="login_password_recover.html">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /login form -->

                    </div>
                    <!-- /content area -->


                    <!-- Footer -->
                    <div class="navbar navbar-sm navbar-footer border-top">
                        <div class="container-fluid justify-content-center my-2">
                            <span>© <?= date('Y') ?> Custom BMS Version <?= $_ENV['APP_VERSION'] ?></span>
                        </div>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /inner content -->

            <div class="btn-to-top"><button class="btn btn-secondary btn-icon rounded-pill" type="button"><i class="ph-arrow-up"></i></button></div></div>
            <!-- /main content -->
            <?php include __DIR__ . '/../includes/flash.php'; ?>

        </div>
        <!-- /page content -->
    </body>
</html>