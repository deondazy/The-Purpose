<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'about';

include __DIR__ . '/includes/header.php'; ?>

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg"
                style="background-image: url(<?= $config->site->url ?>/assets/images/aboutusback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>About Us</h2>
               
            </div>
        </section>
        <!--Page Header End-->

        <!--About Page Start-->
        <section class="about-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="about-page__left">
                            <div class="about-page__img">
                                <img src="<?= $config->site->url ?>/assets/images/about1.png" alt="">
                                <div class="about-page__trusted">
                                    <h3>We’re trusted by <span>9,8750</span> donors</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-page__right">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">What are we about</span>
                                <h2 class="section-title__title">Family - Finance - Education - Real Estate</h2>
                            </div>
                            <p class="about-page__right-text"><span>The Purpose Center</span> is a non-for-profit organization
                            set up for underserved BIPOC communities especially African American communities, with the aim of
                        rebuilding and empowering the youths from poor families through education, financial empowerment and real estate. To create strong families as a means to rebuild our communities, stronger.</p>
                            <h3 class="about-page__right-title">The Purpose Center is all about bringing back purpose into our communities</h3>
                            <div class="about-five__progress-wrap">

                                <div class="about-five__progress">
                                    <div class="about-five__progress-box">
                                        <div class="circle-progress"
                                            data-options='{ "value": 0.9,"thickness": 3,"emptyFill": "#e5eeec","lineCap": "square", "size": 138, "fill": { "color": "#15c8a0" } }'>
                                        </div><!-- /.circle-progress -->
                                        <span>90%</span>
                                    </div>
                                    <div class="about-five__progress-content">
                                        <h3>Success  rate</h3>
                                    </div>
                                </div>
                                <div class="about-five__progress">
                                    <div class="about-five__progress-box">
                                        <div class="circle-progress"
                                            data-options='{ "value": 0.95,"thickness": 3,"emptyFill": "#e5eeec","lineCap": "square", "size": 138, "fill": { "color": "#15c8a0" } }'>
                                        </div><!-- /.circle-progress -->
                                        <span>95%</span>
                                    </div><!-- /.about-five__progress-box -->
                                    <div class="about-five__progress-content">
                                        <h3>Dedication</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--About Page Start-->

        <!--Testimonial One Start-->
        <section class="testimonial-one">
            <div class="testimonial-one-bg"
                style="background-image: url(<?= $config->site->url ?>/assets/images/intro.png)"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="testimonial-one__left">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">Our Testimonials</span>
                                <h2 class="section-title__title">What they are saying about us</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="testimonial-one__right">
                            <div class="testimonial-one__carousel owl-theme owl-carousel">
                                <!--Testimonial One Single-->
                                <div class="testimonial-one__single">
                                    <p class="testimonial-one__text">This is an idea I believe will be crucial in the growth of underserved communities around BIPOC dominated areas and munincipalities in this country</p>
                                    <div class="testimonial-one__client-info">
                                        <div class="testimonial-one__client-img">
                                            <img src="<?= $config->site->url ?>/assets/images/testimonial/testimonial-1-img-1.png" alt="">
                                            <div class="testimonial-one__quote">

                                            </div>
                                        </div>
                                        <div class="testimonial-one__client-name">
                                            <h3>Kevin Martin</h3>
                                            <p>Volunteer</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Testimonial One Single-->
                                <div class="testimonial-one__single">
                                    <p class="testimonial-one__text">Compassion and empathy lay at the heart of ideas like The Purpose Center. I commend the team that are putting this together!</p>
                                    <div class="testimonial-one__client-info">
                                        <div class="testimonial-one__client-img">
                                            <img src="<?= $config->site->url ?>/assets/images/testimonial/testimonial-1-img-2.png" alt="">
                                            <div class="testimonial-one__quote">

                                            </div>
                                        </div>
                                        <div class="testimonial-one__client-name">
                                            <h3>Jessica Brown</h3>
                                            <p>Volunteer</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Testimonial One Single-->
                                <div class="testimonial-one__single">
                                    <p class="testimonial-one__text">I was impressed on multiple levels. The Purpose Center lives up to its very name by providing purpose to these young ones</p>
                                    <div class="testimonial-one__client-info">
                                        <div class="testimonial-one__client-img">
                                            <img src="<?= $config->site->url ?>/assets/images/testimonial/testimonial-1-img-1.png" alt="">
                                            <div class="testimonial-one__quote">

                                            </div>
                                        </div>
                                        <div class="testimonial-one__client-name">
                                            <h3>Jessica Brown</h3>
                                            <p>Volunteer</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Testimonial One Single-->
                                <div class="testimonial-one__single">
                                    <p class="testimonial-one__text">What these guys are doing is amazing. The strength, compassion and dedication this requires is outstanding</p>
                                    <div class="testimonial-one__client-info">
                                        <div class="testimonial-one__client-img">
                                            <img src="<?= $config->site->url ?>/assets/images/testimonial/testimonial-1-img-2.png" alt="">
                                            <div class="testimonial-one__quote">

                                            </div>
                                        </div>
                                        <div class="testimonial-one__client-name">
                                            <h3>Kevin Martin</h3>
                                            <p>Volunteer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Testimonial One End-->

        <!--Join One Start-->
        <section class="join-one join-one__about">
            <div class="join-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
                style="background-image: url(<?= $config->site->url ?>/assets/images/educationhero.png);"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="join-one__inner">
                            <h2 class="join-one__title">Join the community so <br> we can make a difference</h2>
                            <a href="<?= $config->site->url ?>/become-volunteer/" class="join-one__btn thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Join One End-->

        <!--Counters One Start-->
        <section class="counters-one about-page-counter">
            <div class="container">
                <ul class="counters-one__box list-unstyled">
                    <li class="counter-one__single">
                        <h3 class="odometer" data-count="00">00</h3><span class="counter-one__letter">K</span>
                        <p class="counter-one__text">Total Donations</p>
                    </li>
                    <li class="counter-one__single">
                        <h3 class="odometer" data-count="00">00</h3>
                        <p class="counter-one__text">Campaigns Closed</p>
                    </li>
                    <li class="counter-one__single">
                        <h3 class="odometer" data-count="00">00</h3><span class="counter-one__letter">K</span>
                        <p class="counter-one__text">Successful Campaigns</p>
                    </li>
                    <li class="counter-one__single">
                        <h3 class="odometer" data-count="00">00</h3><span class="counter-one__letter">+</span>
                        <p class="counter-one__text">Volunteers</p>
                    </li>
                </ul>
            </div>
        </section>
        <!--Counters One Start-->

        <!--Team One Start-->
        <section class="team-one">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Our Stellar Team</span>
                <h2 class="section-title__title">Meet the best team behind <br> our drivey</h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4">
                    <!--Team One Single-->
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Lenor.png" alt="">
                            </div>
                            <div class="team-one__member-name">
                                <h2>Lenor</h2>
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h4 class="team-one__member-title">Founder</h4>
                            <p class="team-one__text-box">Lenor is a real estate and business mogul who is passionate about giving back to the community.</p>
                        </div>
                        <div class="team-one__social">
                            <a href="https://www.linkedin.com/in/lenor-sherman-6114176b/"><i class="fab fa-linkedin"></i></a>
                            <a href="https://web.facebook.com/lenor.sherman"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://www.instagram.com/lenorsherman/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <!--Team One Single-->
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Tk.png" alt="">
                            </div>
                            <div class="team-one__member-name">
                                <h2>Tk</h2>
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h4 class="team-one__member-title">Co-founder</h4>
                            <p class="team-one__text-box">A serial entrepreneur and assetpreneur. Tk believes in community growth through education and financial literacy. </p>
                        </div>
                        <div class="team-one__social">
                            <a href="https://www.linkedin.com/in/tk-sherman-347511107/"><i class="fab fa-linkedin"></i></a>
                            <a href="https://web.facebook.com/tk.x.sherman"><i class="fab fa-facebook-square"></i></a>
                            
                            <a href="https://www.instagram.com/tkshermanlife/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <!--Team One Single-->
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Victoria.png" alt="">
                            </div>
                            <div class="team-one__member-name">
                                <h2>Victoria</h2>
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h4 class="team-one__member-title">Board Member</h4>
                            <p class="team-one__text-box">CEO Naturally Urban Environmental Inc. The Queen of Green is an ecopreneur and environmental scientist.</p>
                        </div>
                        <div class="team-one__social">
                            <a href="https://www.linkedin.com/in/vwilsonqueenofgreen/"><i class="fab fa-linkedin"></i></a>
                            <a href="https://web.facebook.com/victoria.young.90"><i class="fab fa-facebook-square"></i></a>
                            
                            <a href="https://www.instagram.com/victoria_queenofgreen/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!--Team One End-->

        <!--Brand One Start-->
        <section class="brand-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="brand-one__carousel owl-theme owl-carousel">
                        <!--Brand One Single-->
                        <div class="brand-one__single">
                            <div class="brand-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Logo/partner1.png" alt="">
                            </div>
                        </div>
                        <!--Brand One Single-->
                        <div class="brand-one__single">
                            <div class="brand-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/logo/partner2.png" alt="">
                            </div>
                        </div>
                        <!--Brand One Single-->
                        <div class="brand-one__single">
                            <div class="brand-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Logo/partner 3.png" alt="">
                            </div>
                        </div>
                        <!--Brand One Single-->
                        <div class="brand-one__single">
                            <div class="brand-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/Logo/partner4.png" alt="">
                            </div>
                        </div>
                        <!--Brand One Single-->
                        <div class="brand-one__single">
                            <div class="brand-one__img">
                                <img src="<?= $config->site->url ?>/assets/images/logo/partner5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!--Brand One End-->

        <?php include __DIR__ . '/includes/footer.php';