<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'about';

include __DIR__ . '/includes/header.php'; ?>

       <!--Page Header Start-->
       <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/becomeback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Become a Volunteer</h2>
                
            </div>
        </section>
        <!--Page Header End-->

        <!--Become Volunteer Page Start-->
        <section class="become-volunteer-page">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Register Now</span>
                    <h2 class="section-title__title">Join The Purpose Center <br> as a volunteer</h2>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="become-volunteer-page__left">
                            <div class="become-volunteer-page__img">
                                <img src="assets/images/Become.png" alt="">
                            </div>
                            <h3 class="become-volunteer-page__title">Requirements</h3>
                            <p class="become-volunteer-page__text">The Purpose Center as a non-for-profit will depend on the services of professional paid staffs and the effort of a volunteer force if we are ever going to be successful in executing all our programs around multiple cities and communities.</p>
                            <ul class="become-volunteer-page__list list-unstyled">
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>You must live within the city where you volunteer</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>You must be able to be present at least twice a month</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>Must be at least 18+ years</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>Must at least possess a high school diploma</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                    <div class="text">
                                        <p>Must show a commitment to our values & principles</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="become-volunteer-page__phone">
                                <div class="become-volunteer-page__phone-icon">
                                    <span class="icon-chat"></span>
                                </div>
                                <div class="become-volunteer-page__phone-text">
                                    <p>Call Anytime</p>
                                    <a href="tel:92 666 888 0000">92 666 888 0000</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="become-volunteer-page__right">
                            <form action="http://layerdrops.com/halpes/assets/inc/sendemail.php" class="become-volunteer-page__form contact-form-validated">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="become-volunteer-page__input">
                                            <input type="text" placeholder="Your name" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="become-volunteer-page__input">
                                            <input type="email" placeholder="Email Address" name="email">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="become-volunteer-page__input">
                                            <input type="text" placeholder="Phone Number" name="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="become-volunteer-page__input">
                                            <input type="text" placeholder="Address" name="address">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="become-volunteer-page__input">
                                            <input type="text" placeholder="Date of Birth" name="Date of Birth">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="become-volunteer-page__input">
                                            <input type="text" placeholder="Occupation" name="Occupation">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="become-volunteer-page__input">
                                            <textarea name="message" placeholder="Why do you want to become a volunteer?"></textarea>
                                        </div>
                                        <button type="submit" class="thm-btn become-volunteer-page__btn"><i class="fas fa-arrow-circle-right"></i>Submit Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Become Volunteer Page End-->
        <?php include __DIR__ . '/includes/footer.php';