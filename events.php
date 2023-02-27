<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'events';

include __DIR__ . '/includes/header.php'; ?>

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg"
                style="background-image: url(<?= $config->site->url ?>/assets/images/Eventback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Events</h2>
               
            </div>
        </section>
        <!--Page Header End-->

        <!--Events Page Start-->
        <section class="events-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/resources/events-page-img-1.jpg" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Play for the world
                                            <br> with us</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/resources/events-page-img-2.jpg" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Mission for Fresh
                                            <br>
                                            & Clean Water</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/resources/events-page-img-3.jpg" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Education for <br>
                                            poor
                                            children</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/resources/events-page-img-4.jpg" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Rights for <br>
                                            street
                                            childrens</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/resources/events-page-img-5.jpg" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Help for <br>
                                            needy
                                            people</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/events/sampleevent.png" alt="">
                                <div class="events-one__date-box">
                                    <p>20 <br> Jan</p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i>8:00 pm</p>
                                    <h3 class="events-one__bottom-title"><a href="event-details.html">Donation day <br>
                                            for
                                            people</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Events Page End-->

        <?php include __DIR__ . '/includes/footer.php';