<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'home';

include __DIR__ . '/includes/header.php'; ?>


        <section class="main-slider">
            <div 
                class="swiper-container thm-swiper__slider" 
                data-swiper-options='{
                    "slidesPerView": 1, 
                    "loop": true,
                    "effect": "fade",
                    "pagination": {
                        "el": "#main-slider-pagination",
                        "type": "bullets",
                        "clickable": true
                    },
                    "navigation": {
                        "nextEl": "#main-slider__swiper-button-next",
                        "prevEl": "#main-slider__swiper-button-prev"
                    },
                    "autoplay": {
                        "delay": 5000
                    }}'
            >
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background-image: url(<?= $config->site->url ?>/assets/images/familyhero.jpg);">
                        </div>
                        <div class="image-layer-overlay"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="main-slider__content">
                                        <p>Rebuilding Our Families</p>
                                        <h2>Families build <br>communities</h2>
                                        <a href="<?= $config->site->url ?>/about/" class="thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn
                                            More</a>
                                        <div class="main-slider__shape-1 zoom-fade">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background-image: url(<?= $config->site->url ?>/assets/images/educationhero.png);">
                        </div>
                        <div class="image-layer-overlay"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="main-slider__content">
                                        <p>Educating Our Community</p>
                                        <h2>Education for<br>the young adults</h2>
                                        <a href="<?= $config->site->url ?>/about/" class="thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn
                                            More</a>
                                        <div class="main-slider__shape-1 zoom-fade">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background-image: url(<?= $config->site->url ?>/assets/images/communityhero.png);">
                        </div>
                        <div class="image-layer-overlay"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="main-slider__content">
                                        <p>Empowerment Through Real Estate</p>
                                        <h2>Empower our<br> People </h2>
                                        <a href="<?= $config->site->url ?>/about/" class="thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn
                                            More</a>
                                        <div class="main-slider__shape-1 zoom-fade">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-pagination" id="main-slider-pagination"></div>
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next"><i
                            class="icon-right-arrow icon-left-arrow"></i>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev"><i
                            class="icon-right-arrow"></i>
                    </div>
                </div>
            </div>
        </section>

         <!--Introduction Start-->
         <section class="introduction">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="introduction__left">
                            <div class="introduction__img">
                                <img src="<?= $config->site->url ?>/assets/images/intro.png" alt="">
                            </div>
                            <div class="introduction__content">
                                <p class="introduction__text">The Purpose Center is about the empowerment of minority families and communities through education, real estate and finance</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="introduction__right">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">Our Introduction</span>
                                <h2 class="section-title__title">We can make our communities better!</h2>
                            </div>
                            <p class="introduction__right-text">The Purpose Center aims to create better minority communities by empowering underserved young adults through education and creating relevant workforce from these communities. We are about family, real estate, education and finance.</p>
                            <ul class="introduction__icon-wrap list-unstyled">
                                <li class="introduction__icon-wrap-single">
                                    <div class="introduction__icon-box">
                                        <span class="icon-college-graduation"></span>
                                    </div>
                                    <div class="introduction__content-box">
                                        <h2>Young adult Education</h2>
                                        <p>Young adults from underserved households must be given the opportunity to cultivate a better future by providing them the educational opportunities they lack.</p>
                                    </div>
                                </li>
                                <li class="introduction__icon-wrap-single">
                                    <div class="introduction__icon-box">
                                        <span class="icon-coin"></span>
                                    </div>
                                    <div class="introduction__content-box">
                                        <h2>Financial Empowerment</h2>
                                        <p>By opening financial doors for young adults in our communities, we aim to contribute in providing economic leverage for minority and undeserved communities within Illinois and the United States.</p>
                                    </div>
                                </li>
                            </ul>
                            <a href="<?= $config->site->url ?>/about/" class="introduction__btn thm-btn"><i class="fas fa-arrow-circle-right"></i>Learn
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Introduction End-->

        <!--We Inspire Start-->
         <section class="we-inspire">
            <div class="we-inspire-bg" style="background-image: url(<?= $config->site->url ?>/assets/images/eduback.jpg)"></div>
            <div class="we-inspire-bg-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="we-inspire__left">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">Our Mission and Vision</span>
                                <h2 class="section-title__title">We empower and impact the lives</h2>
                            </div>
                            <div class="we-inspire__faq">
                                <div class="accrodion-grp" data-grp-name="faq-one-accrodion">
                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4>Education of the youths is our priority</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>An educated youthful demographic is the foundation of a prosperous community and nation. We 
                                                    understand that there are many out-of-school young adults in underserved communities especially 
                                                    in communities with high poverty rate. We are committed to creating a path to servicable education
                                                    for young adults in underserved minority communities as a stepping stone to rejuvenating our communities.
                                                </p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                    <div class="accrodion active">
                                        <div class="accrodion-title">
                                            <h4>Financial Empowerment in important</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>In our drive for racial parity, equity, justice and equality, financial empowerment is fundamental to this goal.
                                                    We are committed to the financial empowerment of our community through comprehensive financial literacy education,
                                                    skill acquisition programs and effective workforce development program.
                                                </p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4>Creating healthy and functional families</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>Family is the smallest unit of a society, healthy and functional families are the bedrock for healthy and functional society.
                                                    To rebuild our communities, our goal is to facilitate healthy and functional family units in our communities.
                                                </p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="we-inspire__right">
                            <div class="we-inspire__img">
                                <img src="<?= $config->site->url ?>/assets/images/edu.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--We Inspire End-->

         <!--Four Icon Start-->
         <section class="four-icon">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <!--Four Icon Single-->
                        <div class="four-icon__single">
                            <div class="four-icon__img">
                                <img src="<?= $config->site->url ?>/assets/images/fourFamily.png" alt="">
                                <div class="four-icon__content-box">
                                    <h3 class="four-icon__title">Family</h3>
                                    <p class="four-icon__text">Creating healthy and functional families in our communities.</p>
                                </div>
                            </div>
                            <div class="four-icon__bottom-icon">
                                <span class="icon-dove"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                        <!--Four Icon Single-->
                        <div class="four-icon__single">
                            <div class="four-icon__img">
                                <img src="<?= $config->site->url ?>/assets/images/FourFinance.png" alt="">
                                <div class="four-icon__content-box">
                                    <h3 class="four-icon__title">Finance</h3>
                                    <p class="four-icon__text">Empowering our communities through financial literacy and workforce development</p>
                                </div>
                            </div>
                            <div class="four-icon__bottom-icon">
                                <span class="icon-cheque"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                        <!--Four Icon Single-->
                        <div class="four-icon__single">
                            <div class="four-icon__img">
                                <img src="<?= $config->site->url ?>/assets/images/FourEducation.png" alt="">
                                <div class="four-icon__content-box">
                                    <h3 class="four-icon__title">Education</h3>
                                    <p class="four-icon__text">Educating young adults in underserved families and communities</p>
                                </div>
                            </div>
                            <div class="four-icon__bottom-icon">
                                <span class="icon-donation"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                        <!--Four Icon Single-->
                        <div class="four-icon__single">
                            <div class="four-icon__img">
                                <img src="<?= $config->site->url ?>/assets/images/FourRealestate.png" alt="">
                                <div class="four-icon__content-box">
                                    <h3 class="four-icon__title">Real estate</h3>
                                    <p class="four-icon__text">Getting our communities a seat at the modern economy through real estate</p>
                                </div>
                            </div>
                            <div class="four-icon__bottom-icon">
                                <span class="icon-handshake"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Four Icon End-->

        <!--Become Volunteer Start-->
        <section class="become-volunteer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="become-volunteer__inner">
                            <div class="become-volunteer__left">
                                <h2>Join your hand with us to <br>create a better community</h2>
                                <div class="become-volunteer__big-text">
                                    <h2>Become a Participant</h2>
                                </div>
                            </div>
                            <div class="become-volunteer__btn-box">
                                <a href="<?= $config->site->url ?>/become-volunteer/" class="become-volunteer__btn thm-btn"><i
                                        class="fas fa-arrow-circle-right"></i>Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Become Volunteer End-->

        <!--Team One Start-->
        <section class="team-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Our Stellar Team</span>
                    <h2 class="section-title__title">Meet the best team behind <br> our drive</h2>
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

        <!--Three Boxes Start-->
        <section class="three-boxes">
            <div class="container-box">
                <div class="row">
                    <div class="col-xl-4">
                        <!--Three Boxes Single-->
                        <div class="three-boxes__single">
                            <div class="three-boxes__single-bg"
                                style="background-image: url(<?= $config->site->url ?>/assets/images/ThreeHealth.png)""></div>
                            <div class="three-boxes__content">
                                <div class="three-boxes__icon">
                                    <span class="icon-fast-food"></span>
                                </div>
                                <div class="three-boxes__text-box">
                                    <h2>Healthy Community</h2>
                                    <p class="three-boxes__text">Underserved youths deserve healthy lifestyle if they are to grow and be nurtured into productive individuals</p>
                                    <a href="<?= $setting->getSetting('donate_link') ?>" class="three-boxes__btn"><i class="fa fa-heart"></i>Donate </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <!--Three Boxes Single-->
                        <div class="three-boxes__single three-boxes__single-item-two">
                            <div class="three-boxes__single-bg"
                                style="background-image: url(<?= $config->site->url ?>/assets/images/Threeeducation.png)"></div>
                            <div class="three-boxes__content">
                                <div class="three-boxes__icon">
                                    <span class="icon-water"></span>
                                </div>
                                <div class="three-boxes__text-box">
                                    <h2>Educated Community</h2>
                                    <p class="three-boxes__text">Provide educational opportunities for underserved youths especially ones from poor homes</p>
                                    <a href="<?= $setting->getSetting('donate_link') ?>" class="three-boxes__btn"><i class="fa fa-heart"></i>Donate </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <!--Three Boxes Single-->
                        <div class="three-boxes__single three-boxes__single-item-three">
                            <div class="three-boxes__single-bg"
                                style="background-image: url(<?= $config->site->url ?>/assets/images/resources/three-boxes-img-1.jpg)"></div>
                            <div class="three-boxes__content">
                                <div class="three-boxes__icon">
                                    <span class="icon-health-check"></span>
                                </div>
                                <div class="three-boxes__text-box">
                                    <h2>Empowered Community</h2>
                                    <p class="three-boxes__text">Through financial literacy, skill acquisition and real estate we can open doors for a prosperous community</p>
                                    <a href="<?= $setting->getSetting('donate_link') ?>" class="three-boxes__btn"><i class="fa fa-heart"></i>Donate </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Three Boxes End-->

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
                                            <p>Participant</p>
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
                                            <p>Participant</p>
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
                                            <p>Participant</p>
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
                                            <p>Participant</p>
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

        <!--Help Them Start-->
        <section class="help-them">
            <div class="help-them-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
                style="background-image: url(<?= $config->site->url ?>/assets/images/familyhero.png)"></div>
            <div class="container">
                <div class="help-them__top">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <div class="help-them__top-content">
                                <h2 class="help-them__top-content-title">Bringing back purpose and empowerment</h2>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="help-them__top-video-box">
                                <a href="https://www.youtube.com/watch?v=i9E_Blai8vk"
                                    class="help-them__top-video-btn video-popup"><i class="fa fa-play"></i></a>
                                <p class="help-them__top-video-text">Watch Our Video</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="help-them__bottom">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <!--Help Them Single-->
                            <div class="help-them__single">
                                <div class="help-them__icon">
                                    <span class="icon-charity"></span>
                                </div>
                                <div class="help-them__text">
                                    <h3>Become a participant</h3>
                                    <p>If you want to help us in the field, you can become a participant and be a part of our program</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <!--Help Them Single-->
                            <div class="help-them__single">
                                <div class="help-them__icon">
                                    <span class="icon-generous"></span>
                                </div>
                                <div class="help-them__text">
                                    <h3>Fundraising</h3>
                                    <p>These human and community development projects require funding to work. Donate to us</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <!--Help Them Single-->
                            <div class="help-them__single">
                                <div class="help-them__icon">
                                    <span class="icon-fundraiser"></span>
                                </div>
                                <div class="help-them__text">
                                    <h3>Start Donating</h3>
                                    <p>We appreciate every dollar, every penny. It can make a world of difference</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Help Them End-->

        <!--News Three Start
        <section class="news-two news-three">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Keep us with us</span>
                    <h2 class="section-title__title">Our latest activies<br> posted on our blog</h2>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                        <!--News Two Single--
                        <div class="news-two__single">
                            <div class="news-two__img-box">
                                <div class="news-two__img">
                                    <img src="/assets/images/blog/blogfamily.png" alt="">
                                    <a href="news-details.html">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="news-two__date">
                                    <p>20 Jan, 2021</p>
                                </div>
                            </div>
                            <div class="news-two__content">
                                <ul class="list-unstyled news-two__meta">
                                    <li><a href="index3.html#"><i class="far fa-user-circle"></i> Admin</a></li>
                                    <li><span>/</span></li>
                                    <li><a href="index3.html#"><i class="far fa-comments"></i> 2 Comments</a>
                                    </li>
                                </ul>
                                <h3>
                                    <a href="news-details.html">Building A Family The Right Way</a>
                                </h3>
                                <p class="news-two__text">There are many variations of but the majority have simply free
                                    text available not suffered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <!--News Two Single--
                        <div class="news-two__single">
                            <div class="news-two__img-box">
                                <div class="news-two__img">
                                    <img src="/assets/images/blog/blogeducation.png" alt="">
                                    <a href="news-details.html">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="news-two__date">
                                    <p>20 Jan, 2021</p>
                                </div>
                            </div>
                            <div class="news-two__content">
                                <ul class="list-unstyled news-two__meta">
                                    <li><a href="index3.html#"><i class="far fa-user-circle"></i> Admin</a></li>
                                    <li><span>/</span></li>
                                    <li><a href="index3.html#"><i class="far fa-comments"></i> 2 Comments</a>
                                    </li>
                                </ul>
                                <h3>
                                    <a href="news-details.html">How Important Is Education?</a>
                                </h3>
                                <p class="news-two__text">There are many variations of but the majority have simply free
                                    text available not suffered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                        <!--News Two Single--
                        <div class="news-two__single">
                            <div class="news-two__img-box">
                                <div class="news-two__img">
                                    <img src="/assets/images/blog/blogrealestate.png" alt="">
                                    <a href="news-details.html">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="news-two__date">
                                    <p>20 Jan, 2021</p>
                                </div>
                            </div>
                            <div class="news-two__content">
                                <ul class="list-unstyled news-two__meta">
                                    <li><a href="index3.html#"><i class="far fa-user-circle"></i> Admin</a></li>
                                    <li><span>/</span></li>
                                    <li><a href="index3.html#"><i class="far fa-comments"></i> 2 Comments</a>
                                    </li>
                                </ul>
                                <h3>
                                    <a href="news-details.html">Real Estate and Equality</a>
                                </h3>
                                <p class="news-two__text">There are many variations of but the majority have simply free
                                    text available not suffered.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--News Three End-->

        <!--Gallery One Start-
        <section class="gallery-one">
            <div class="gallery-one__container-box clearfix">
                <div class="gallery-one__carousel owl-theme owl-carousel">
                    <!--Gallery One Single-
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="/assets/images/gallery/gallery1.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                    <!--Gallery One Single-
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="/assets/images/gallery/gallery2.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                    <!--Gallery One Single--
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="/assets/images/gallery/gallery3.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                    <!--Gallery One Single--
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="/assets/images/gallery/gallery4.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                    <!--Gallery One Single--
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="/assets/images/gallery/gallery5.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-one__single">
                        <div class="gallery-one__img-box">
                            <img src="assets/images/gallery/gallery6.png" alt="">
                            <div class="gallery-one__hover-content-box">
                                <h2>The Purpose</h2>
                                <p>Center</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Gallery One End-->

        <?php include __DIR__ . '/includes/footer.php';