<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'about';

include __DIR__ . '/includes/header.php'; ?>

       <!--Page Header Start-->
       <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/galleryback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Gallery</h2>
            </div>
        </section>
        <!--Page Header End-->

        <!--Gallery page Start-->
        <section class="gallery-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery1.png" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>The Purpose Centers</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-2.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-3.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-4.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-5.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-6.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-7.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-8.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box">
                                <img src="<?= $config->site->url ?>/assets/images/gallery/gallery-page-img-9.jpg" alt="">
                                <div class="gallery-page__hover-content-box">
                                    <h2>Child Education</h2>
                                    <p>Charity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Gallery page End-->

        <?php include __DIR__ . '/includes/footer.php';