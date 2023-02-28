<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'about';

include __DIR__ . '/includes/header.php'; ?>

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/volunteerback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Volunteers</h2>
            </div>
        </section>
        <!--Page Header End-->

        <!--Become Volunteer Start-->
        <section class="become-volunteer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="become-volunteer__inner">
                            <div class="become-volunteer__left">
                                <h2>Join your hand with us for <br> a better life and future</h2>
                                <div class="become-volunteer__big-text">
                                    <h2>Become a Volunteer</h2>
                                </div>
                            </div>
                            <div class="become-volunteer__btn-box">
                                <a href="become-volunteer.html" class="become-volunteer__btn thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Become Volunteer End-->
        <?php include __DIR__ . '/includes/footer.php';