<?php 
$user = new Core\Models\User($connection);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purpose Center Chicago</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $config->site->url ?>/assets/images/Logo/logoblue.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $config->site->url ?>/assets/images/Logo/logoblue.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $config->site->url ?>/assets/images/logo/logoblue.png" />
    <link rel="manifest" href="<?= $config->site->url ?>/assets/images/Logo/logoblue.png" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/animate/animate.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/halpes-icons/style.css">
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/reey-font/stylesheet.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/vendors/owl-carousel/owl.theme.default.min.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/css/halpes.css" />
    <link rel="stylesheet" href="<?= $config->site->url ?>/assets/css/halpes-responsive.css" />
</head>

<body>
    <div class="preloader">
        <img class="preloader__image" width="60" src="<?= $config->site->url ?>/public/assets/images/logoblue.png" alt="" />
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
        <header class="main-header clearfix">
            <div class="main-header__logo">
                <a class="" href="<?= $config->site->url ?>">
                    <img class="" width="100" src="<?= $config->site->url ?>/public/assets/images/icon.svg" alt="" />
                    <img class="" width="140" src="<?= $config->site->url ?>/public/assets/images/logo.svg" alt="" />
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="main-menu-wrapper__top">
                    <div class="main-menu-wrapper__top-inner">
                        <div class="main-menu-wrapper__left">
                            <div class="main-menu-wrapper__left-content">
                                <div class="main-menu-wrapper__left-text">
                                    <p>Welcome to Purpose Center</p>
                                </div>
                                <div class="main-menu-wrapper__left-email-box">
                                    <div class="icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="email">
                                        <a href="mailto:Info@purposecenters.com">Info@purposecenters.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-menu-wrapper__right">
                            <div class="main-menu-wrapper__right-social">
                                <a href="index.html#"><i class="fab fa-twitter"></i></a>
                                <a href="index.html#"><i class="fab fa-facebook-square"></i></a>
                                <a href="index.html#"><i class="fab fa-dribbble"></i></a>
                                <a href="index.html#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-menu-wrapper__bottom">
                    <?php include __DIR__ . '/navigation.php'; ?>
                </div>
            </div>

        </header>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->