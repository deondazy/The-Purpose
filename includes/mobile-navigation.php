<div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="<?= $config->site->url ?>" aria-label="logo image">
                    <img class="" width="100" src="<?= $config->site->url ?>/public/assets/images/icon.svg" alt="<?= $setting->getSetting('site_name') ?>" />
                    <img class="" width="140" src="<?= $config->site->url ?>/public/assets/images/logo.svg" alt="<?= $setting->getSetting('site_name') ?>" />
                </a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:<?= $setting->getSetting('site_email') ?>"><?= $setting->getSetting('site_email') ?></a>
                </li>
                <li>
                    <i class="fa fa-phone-alt"></i>
                    <a href="tel:<?= $setting->getSetting('site_phone') ?>"><?= $setting->getSetting('site_phone') ?></a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="<?= $setting->getSetting('site_twitter') ?>" class="fab fa-twitter"></a>
                    <a href="<?= $setting->getSetting('site_facebook') ?>" class="fab fa-facebook-square"></a>
                    <a href="<?= $setting->getSetting('site_instagram') ?>" class="fab fa-instagram"></a>
                    <a href="<?= $setting->getSetting('site_youtube') ?>" class="fab fa-youtube"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->

        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->