<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'contact';

include __DIR__ . '/includes/header.php'; ?>

       <!--Page Header Start-->
       <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/contactback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Contact</h2>
               
            </div>
        </section>
        <!--Page Header End-->

        <!--Contact page Start-->
        <section class="contact-page">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Contact Us</span>
                    <h2 class="section-title__title">We'd love to hear from you</h2>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="contact-page__left">
                            <div class="contact-page__img">
                                <img src="assets/images/Become.png" alt="">
                            </div>
                            <p class="contact-page__text">You can reach us through any of the channels below or on our social media pages. You can also send a direct message quickly from this page</p>
                            <div class="contact-page__contact-info">
                                <ul class="contact-page__contact-list list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-chat"></span>
                                        </div>
                                        <div class="text">
                                            <p>Call Anytime</p>
                                            <a href="tel:<?= $setting->getSetting('site_phone') ?>"><?= $setting->getSetting('site_phone') ?></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-message"></span>
                                        </div>
                                        <div class="text">
                                            <p>Send Email</p>
                                            <a href="mailto:<?= $setting->getSetting('site_email') ?>"><?= $setting->getSetting('site_email') ?></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-address"></span>
                                        </div>
                                        <div class="text">
                                            <p>Visit Office</p>
                                            <h5><?= $setting->getSetting('site_address') ?></h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="contact-page__form">
                            <form action="#" class="contact-page__main-form contact-form-validated">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="contact-page__input-box">
                                            <input type="text" placeholder="Your name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="contact-page__input-box">
                                            <input type="email" placeholder="Email address" name="email">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="contact-page__input-box">
                                            <input type="text" placeholder="Subject" name="subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="contact-page__input-box">
                                            <input type="text" placeholder="Phone Number" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="contact-page__input-box">
                                            <textarea name="message" placeholder="Write message"></textarea>
                                        </div>
                                        <button type="submit" class="thm-btn contact-page__btn"><i class="fas fa-arrow-circle-right"></i>Send a Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact page End-->

        <!--Contact Page Google Map Start-->
        <section class="contact-page-google-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2977.4160219196115!2d-87.55559023125547!3d41.73311871260515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e27e2eba6f175%3A0x4ab755fdaa3a67f0!2s8915%20S%20Commercial%20Ave%2C%20Chicago%2C%20IL%2060617%2C%20USA!5e0!3m2!1sen!2sng!4v1677580247503!5m2!1sen!2sng" class="contact-page-google-map__one" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd" class="contact-page-google-map__one" allowfullscreen></iframe> -->

        </section>
        <!--Contact Page Google Map End-->

        <!--Become Volunteer Start-->
        <section class="become-volunteer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="become-volunteer__inner">
                            <div class="become-volunteer__left">
                                <h2>Join your hand with us for <br> a better life and future</h2>
                                <div class="become-volunteer__big-text">
                                    <h2>Become a Participant</h2>
                                </div>
                            </div>
                            <div class="become-volunteer__btn-box">
                                <a href="<?= $config->site->url ?>/participant/" class="become-volunteer__btn thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Become Volunteer End-->
        <?php include __DIR__ . '/includes/footer.php';