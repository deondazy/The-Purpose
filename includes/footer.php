<!--Site Footer One Start-->
<footer class="site-footer">
    <div class="site-footer-bg" style="background-image: url(<?= $config->site->url ?>/assets/images/backgrounds/footer-bg.jpg)"></div>
    <div class="container">
        <div class="site-footer__top">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <h3 class="footer-widget__title">About</h3>
                        <p class="footer-widget__text">We are about empowering the undeserved in our community. Building on family, real estate, education and finance.

                            </p>
                        <a href="<?= $setting->getSetting('donate_link') ?>" class="footer-widget__about-btn"><i class="fa fa-heart"></i>Donate </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="footer-widget__column footer-widget__explore clearfix">
                        <h3 class="footer-widget__title">Explore</h3>
                        <ul class="footer-widget__explore-list list-unstyled">
                            <li><a href="<?= $setting->getSetting('donate_link') ?>">Donate</a></li>
                            <li><a href="<?= $config->site->url ?>/events/">Events</a></li>
                            <li><a href="<?= $config->site->url ?>/blog/">Blog</a></li>
                            <li><a href="<?= $config->site->url ?>/participants/">Participants</a></li>
                            <li><a href="<?= $config->site->url ?>/contact/">Contact Us</a></li>
                        </ul>
                        <!-- <ul class="footer-widget__explore-list footer-widget__explore-list-two list-unstyled">
                            
                            <li><a href="index.html#">Home</a></li>
                            <li><a href="index.html#">Help</a></li>
                            <li><a href="index.html#">Faqs</a></li>
                        </ul> -->
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="footer-widget__column footer-widget__contact">
                        <h3 class="footer-widget__title">Contact</h3>
                        <ul class="list-unstyled footer-widget__contact-list">
                            <li>
                                <div class="icon">
                                    <i class="icon-chat"></i>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>Call Anytime</span>
                                        <a href="tel:<?= $setting->getSetting('site_phone') ?>"><?= $setting->getSetting('site_phone') ?></a>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="icon-message"></i>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>Send Email</span>
                                        <a href="mailto:<?= $setting->getSetting('site_email') ?>"><?= $setting->getSetting('site_email') ?></a>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="icon-address"></i>
                                </div>
                                <div class="text">
                                    <p><span>Visit Office</span><?= $setting->getSetting('site_address') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="footer-widget__column footer-widget__newsletter">
                        <h3 class="footer-widget__title">Newsletter</h3>
                        <p class="footer-widget__newsletter-text">Keep in touch with us. Subscribe to our newsletter.</p>
                        <form class="footer-widget__newsletter-form">
                            <input type="email" placeholder="Email address" name="email">
                            <button type="submit" class="footer-widget__newsletter-btn"><i
                                    class="fas fa-arrow-circle-right"></i>Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-footer__bottom-inner">
                        <div class="site-footer__bottom-logo-social">
                            <div class="site-footer__bottom-logo">
                                <a href="<?= $config->site->url ?>">
                                    <img class="" width="100" src="<?= $config->site->url ?>/public/assets/images/icon.svg" alt="" />
                                    <img class="" width="140" src="<?= $config->site->url ?>/public/assets/images/logo.svg" alt="" />
                                </a>
                            </div>
                            <div class="site-footer__bottom-social">
                                <a href="<?= $setting->getSetting('site_twitter') ?>"><i class="fab fa-twitter"></i></a>
                                <a href="<?= $setting->getSetting('site_facebook') ?>"><i class="fab fa-facebook-square"></i></a>
                                <a href="<?= $setting->getSetting('site_instagram') ?>"><i class="fab fa-instagram"></i></a>
                                <a href="<?= $setting->getSetting('site_youtube') ?>"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                        <div class="site-footer__bottom-copy-right">
                            <p>© Copyright <?= date('Y') ?> by <a href="www.johnagbaeze.com"> John Chukwuemeka Agbaeze</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--Site Footer One End-->

</div><!-- /.page-wrapper -->


<?php include __DIR__ . '/mobile-navigation.php'; ?>

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <script src="<?= $config->site->url ?>/assets/vendors/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jarallax/jarallax.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/nouislider/nouislider.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/odometer/odometer.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/swiper/swiper.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/tiny-slider/tiny-slider.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/wnumb/wNumb.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/wow/wow.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/isotope/isotope.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/countdown/countdown.min.js"></script>
    <script src="<?= $config->site->url ?>/assets/vendors/owl-carousel/owl.carousel.min.js"></script>
    <!-- template js -->
    <script src="<?= $config->site->url ?>/assets/js/halpes.js"></script>
</body>

</html>