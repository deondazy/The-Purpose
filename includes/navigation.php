<?php 

function currentLink($current) 
{
    global $page;
    return ($page == $current) ? 'current' : '';
}

?>

<nav class="main-menu">
    <div class="main-menu__inner">
        <button class="mobile-nav__toggler"><i class="fa fa-bars"></i></button>
        <ul class="main-menu__list">
            <li class="<?= currentLink('home') ?>">
                <a href="<?= $config->site->url ?>/">Home</a>
            </li>

            <li class="dropdown <?= currentLink('about') ?>">
                <a href="<?= $config->site->url ?>/about/">About Us</a>
                <ul>
                    <li><a href="<?= $config->site->url ?>/participants/">Participants</a></li>
                    <li><a href="<?= $config->site->url ?>/gallery/">Gallery</a></li>
                    <li><a href="<?= $config->site->url ?>/become-participant/">Become a Participant</a></li>
                </ul>
            </li>
            
            <li class="<?= currentLink('events') ?>">
                <a href="<?= $config->site->url ?>/events/">Events</a>
            </li>

            <li class="<?= currentLink('blog') ?>">
                <a href="<?= $config->site->url ?>/blog/">Blog</a>
                
            </li>
            <li class="<?= currentLink('contact') ?>"><a href="<?= $config->site->url ?>/contact/">Contact Us</a></li>
        </ul>
        <div class="main-menu__right">
            <div class="main-menu__phone-contact">
                <div class="main-menu__phone-icon">
                    <span class="icon-chat"></span>
                </div>
                <div class="main-menu__phone-number">
                    <p>Call Anytime</p>
                    <a href="tel:<?= $setting->getSetting('site_phone') ?>"><?= $setting->getSetting('site_phone') ?></a>
                </div>
            </div>
            <a href="<?= $setting->getSetting('donate_link') ?>" class="main-menu__donate-btn"><i class="fa fa-heart"></i>Donate </a>
        </div>
    </div>
</nav>