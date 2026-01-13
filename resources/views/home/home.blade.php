
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
    ============================================= -->
    <title>NR SHARE - Home</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/logoicon.png') }}">

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Top Bar
    ============================================= -->
    <div id="top-bar">
        <div class="container clearfix">

            <div class="row justify-content-between">
                <div class="col-12 col-md-auto">

                    <!-- Top Links
                    ============================================= -->
                    <div class="top-links on-click">
                        <ul class="top-links-container">
                            <li class="top-links-item"><a href="faqs.html">FAQs</a></li>
                            <li class="top-links-item"><a href="contact.html">Contact</a></li>
                            <li class="top-links-item"><a href="login-register.html">Login</a>
                                <div class="top-links-section">
                                    <form id="top-login" autocomplete="off">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="email" class="form-control" placeholder="Email address">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" placeholder="Password" required="">
                                        </div>
                                        <div class="form-group form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="top-login-checkbox">
                                            <label class="form-check-label" for="top-login-checkbox">Remember Me</label>
                                        </div>
                                        <button class="btn btn-danger w-100" type="submit">Sign in</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div><!-- .top-links end -->

                </div>

                <div class="col-12 col-md-auto">

                    <!-- Top Social
                    ============================================= -->
                    <ul id="top-social">
                        <li><a href="#" class="si-facebook"><span class="ts-icon"><i class="icon-facebook"></i></span><span class="ts-text">Facebook</span></a></li>
                        <li><a href="#" class="si-twitter"><span class="ts-icon"><i class="icon-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
                        <li class="d-none d-sm-flex"><a href="#" class="si-dribbble"><span class="ts-icon"><i class="icon-dribbble"></i></span><span class="ts-text">Dribbble</span></a></li>
                        <li><a href="#" class="si-github"><span class="ts-icon"><i class="icon-github-circled"></i></span><span class="ts-text">Github</span></a></li>
                        <li class="d-none d-sm-flex"><a href="#" class="si-pinterest"><span class="ts-icon"><i class="icon-pinterest"></i></span><span class="ts-text">Pinterest</span></a></li>
                        <li><a href="#" class="si-instagram"><span class="ts-icon"><i class="icon-instagram2"></i></span><span class="ts-text">Instagram</span></a></li>
                        <li><a href="tel:+1.11.85412542" class="si-call"><span class="ts-icon"><i class="icon-call"></i></span><span class="ts-text">+1.11.85412542</span></a></li>
                        <li><a href="mailto:info@canvas.com" class="si-email3"><span class="ts-icon"><i class="icon-email3"></i></span><span class="ts-text">info@canvas.com</span></a></li>
                    </ul><!-- #top-social end -->

                </div>

            </div>

        </div>
    </div><!-- #top-bar end -->

    <!-- Header
    ============================================= -->
    <header id="header" class="header-size-sm" data-sticky-shrink="false">
        <div class="container">
            <div class="header-row flex-column flex-lg-row justify-content-center justify-content-lg-start">

                <!-- Logo
                ============================================= -->
                <div id="logo" class="me-0 me-lg-auto">
                    <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ asset('images/logo3.png') }}"><img src="{{ asset('images/logo3.png') }}" alt="SHARE Logo"></a>
                    <a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ asset('images/logo3.png') }}"><img src="{{ asset('images/logo3.png') }}" alt="SHARE Logo"></a>
                </div>
                <!-- #logo end -->

                <div class="header-misc mb-4 mb-lg-0 d-none d-lg-flex">
                    <div class="top-advert">
                        <img src="images/magazine/ad.jpg" alt="Ad">
                    </div>
                </div>

            </div>
        </div>

        <div id="header-wrap" class="border-top border-f5">
            <div class="container">
                <div class="header-row justify-content-between">

                    <div class="header-misc">

                        <!-- Top Search
                        ============================================= -->
                        <div id="top-search" class="header-misc-icon">
                            <a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
                        </div><!-- #top-search end -->

                    </div>

                    <div id="primary-menu-trigger">
                        <svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
                    </div>

                    <!-- Primary Navigation
                    ============================================= -->
                    <nav class="primary-menu">

                        <ul class="menu-container">
                            <li class="menu-item {{ route('home') == url()->current() ? 'current' : '' }}">
                                <a class="menu-link" href="{{ route('home') }}"><div>Home</div></a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="#"><div>Reports</div></a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="#"><div>Portfolio</div></a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="#"><div>Galery</div></a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="#"><div>About Us</div></a>
                            </li>
                        </ul>

                    </nav><!-- #primary-menu end -->

                    <form class="top-search-form" action="search.html" method="get">
                        <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
                    </form>

                </div>

            </div>
        </div>
        <div class="header-wrap-clone"></div>
    </header><!-- #header end -->

    <!-- Content
    ============================================= -->
    <section id="content">
        <div class="content-wrap">

            <div class="section header-stick bottommargin-lg py-3">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-auto">
                            <div class="d-flex">
                                <span class="badge bg-danger text-uppercase col-auto">Proposal Bantuan</span>
                            </div>
                        </div>

                        <div class="col-lg mt-2 mt-lg-0">
                            <div class="fslider" data-speed="800" data-pause="6000" data-arrows="false" data-pagi="false" style="min-height: 0;">
                                <div class="flexslider">
                                    <div class="slider-wrap">
                                        <div class="slide"><a href="#"><strong>Russia hits back, says US acts like a 'bad surgeon'..</strong></a></div>
                                        <div class="slide"><a href="#"><strong>'Sulking' Narayan Rane needs consolation: Uddhav reacts to Cong leader's attack..</strong></a></div>
                                        <div class="slide"><a href="#"><strong>Rane needs consolation. I pray to God that he gets mental peace in a political party..</strong></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container clearfix">

                <div class="row">
                    <div class="col-lg-8 bottommargin">

                        <div class="row col-mb-50">
                            <div class="col-12">
                                <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap">
                                            <div class="slide" data-thumb="{{ asset('template/assets/images/home/csr1.jpg') }}">
                                                <a href="#">
                                                    <img src="{{ asset('template/assets/images/home/csr1.jpg') }}" alt="Image">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start">
                                                            <div class="portfolio-desc py-0">
                                                                <h3>Locked Steel Gate</h3>
                                                                <span>Illustrations</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="slide" data-thumb="{{ asset('template/assets/images/home/csr2.jpg') }}">
                                                <a href="#">
                                                    <img src="{{ asset('template/assets/images/home/csr2.jpg') }}" alt="Image">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start">
                                                            <div class="portfolio-desc py-0">
                                                                <h3>Russia hits back, says US acts like a 'bad surgeon'</h3>
                                                                <span><i class="icon-star3 me-1"></i><i class="icon-star3 me-1"></i><i class="icon-star3 me-1"></i><i class="icon-star-half-full me-1"></i><i class="icon-star-empty"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="slide" data-thumb="{{ asset('template/assets/images/home/csr3.jpg') }}">
                                                <a href="#">
                                                    <img src="{{ asset('template/assets/images/home/csr3.jpg') }}" alt="Image">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start">
                                                            <div class="portfolio-desc py-0">
                                                                <h3>Locked Steel Gate</h3>
                                                                <span>Technology</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="slide" data-thumb="images/magazine/thumb/4.jpg">
                                                <iframe src="https://player.vimeo.com/video/99895335" width="500" height="281" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                            </div>
                                            <div class="slide" data-thumb="images/magazine/thumb/5.jpg">
                                                <a href="#">
                                                    <img src="images/magazine/5.jpg" alt="Image">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start">
                                                            <div class="portfolio-desc py-0">
                                                                <h3>Locked Steel Gate</h3>
                                                                <span><i class="icon-star3 me-1"></i><i class="icon-star3 me-1"></i><i class="icon-star3 me-1"></i><i class="icon-star-half-full me-1"></i><i class="icon-star-empty"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="slide" data-thumb="images/magazine/thumb/6.jpg">
                                                <a href="#">
                                                    <img src="images/magazine/6.jpg" alt="Image">
                                                    <div class="bg-overlay">
                                                        <div class="bg-overlay-content text-overlay-mask dark align-items-end justify-content-start">
                                                            <div class="portfolio-desc py-0">
                                                                <h3>Locked Steel Gate</h3>
                                                                <span>Entertainment</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">

                                <div class="fancy-title title-border">
                                    <h3>Technology</h3>
                                </div>

                                <div class="posts-md">
                                    <div class="entry row mb-5">
                                        <div class="col-md-6">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/7.jpg" alt="Image"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <div class="entry-title title-sm nott">
                                                <h3><a href="blog-single.html">Toyotas next minivan will let you shout at your kids without turning around</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 21</a></li>
                                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p class="mb-0">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="posts-sm row col-mb-30">
                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/1.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">UK government weighs Tesla's Model S for its 5 million electric vehicle fleet</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 1st Aug 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 32</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/2.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">MIT's new robot glove can give you extra fingers</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 13th Sep 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 11</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/3.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">You can now listen to headphones through your hoodie</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 27th July 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 13</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/4.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">How would you change Kobo's Aura HD e-reader?</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 31st Jan 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 7</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <img src="images/magazine/ad.jpg" alt="Ad" class="aligncenter my-0">
                            </div>

                            <div class="col-12">

                                <div class="fancy-title title-border">
                                    <h3>Entertainment</h3>
                                </div>

                                <div class="posts-md">
                                    <div class="entry row mb-5">
                                        <div class="col-md-6">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/8.jpg" alt="Image"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <div class="entry-title title-sm nott">
                                                <h3><a href="blog-single.html">Beyonce Dropped A '50 Shades Of Grey', Teaser On Instagram Last Night</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 7th Jun 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 23</a></li>
                                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p class="mb-0">Neque nesciunt molestias soluta esse debitis. Magni impedit quae consectetur consequuntur adipisci veritatis modi a, officia cum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="posts-sm row col-mb-30">
                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/5.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">A Baseball Team Blew Up A Bunch Of Justin Bieber And Miley Cyrus Merch</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 5th Nov 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 3</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/6.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">Want To Know The New 'Star Wars' Plot? Then This Is The Post For You</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 29th Jul 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 22</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/7.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">Actress Skye McCole Bartusiak From 'The Patriot' Found Dead At 21</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 12th Oct 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 47</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-md-6">
                                        <div class="grid-inner row g-0">
                                            <div class="col-auto">
                                                <div class="entry-image">
                                                    <a href="#"><img src="images/magazine/small/9.jpg" alt="Image"></a>
                                                </div>
                                            </div>
                                            <div class="col ps-3">
                                                <div class="entry-title">
                                                    <h4><a href="#">Internet Slang Has Been Proof Of Satanic Worship All Along??? LOL!</a></h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i class="icon-calendar3"></i> 25th Mar 2021</li>
                                                        <li><a href="#"><i class="icon-comments"></i> 56</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="fancy-title title-border">
                                    <h3>News in Pictures</h3>
                                </div>

                                <div class="masonry-thumbs grid-container grid-6" data-big="5" data-lightbox="gallery">
                                    <a class="grid-item" href="images/magazine/1.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/1.jpg" alt="Gallery Thumb 1"></a>
                                    <a class="grid-item" href="images/magazine/2.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/2.jpg" alt="Gallery Thumb 2"></a>
                                    <a class="grid-item" href="images/magazine/3.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/3.jpg" alt="Gallery Thumb 3"></a>
                                    <a class="grid-item" href="images/magazine/4.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/4.jpg" alt="Gallery Thumb 4"></a>
                                    <a class="grid-item" href="images/magazine/5.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/5.jpg" alt="Gallery Thumb 5"></a>
                                    <a class="grid-item" href="images/magazine/6.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/6.jpg" alt="Gallery Thumb 6"></a>
                                    <a class="grid-item" href="images/magazine/7.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/7.jpg" alt="Gallery Thumb 7"></a>
                                    <a class="grid-item" href="images/magazine/8.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/8.jpg" alt="Gallery Thumb 8"></a>
                                    <a class="grid-item" href="images/magazine/9.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/9.jpg" alt="Gallery Thumb 9"></a>
                                    <a class="grid-item" href="images/magazine/10.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/10.jpg" alt="Gallery Thumb 10"></a>
                                    <a class="grid-item" href="images/magazine/11.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/11.jpg" alt="Gallery Thumb 11"></a>
                                    <a class="grid-item" href="images/magazine/12.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/12.jpg" alt="Gallery Thumb 12"></a>
                                    <a class="grid-item" href="images/magazine/13.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/13.jpg" alt="Gallery Thumb 13"></a>
                                    <a class="grid-item" href="images/magazine/14.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/14.jpg" alt="Gallery Thumb 14"></a>
                                    <a class="grid-item" href="images/magazine/15.jpg" data-lightbox="gallery-item"><img src="images/magazine/thumb/15.jpg" alt="Gallery Thumb 15"></a>
                                </div>
                            </div>

                            <div class="col-12">

                                <div class="fancy-title title-border">
                                    <h3>Other News</h3>
                                </div>

                                <div class="row posts-md col-mb-30">
                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/11.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">Yum, McDonald's apologize as new China food scandal brews</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 9th Sep 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 23</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Neque nesciunt molestias soluta esse debitis. Magni impedit quae consectetur consequuntur.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/16.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">Halliburton gets boost from rebound in North America drilling</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 23rd Aug 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 33</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Eaque iusto quod assumenda beatae, nesciunt aliquid. Vel, eos eligendi?</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/13.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">China sends spy ship off Hawaii during U.S.-led drills brews</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 11th Feb 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Magni impedit quae consectetur consequuntur adipisci veritatis modi a, officia cum.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/10.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">Wobbly stocks underpin yen and Swiss franc; dollar subdued</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 17th Jan 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 50</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Neque nesciunt molestias soluta esse debitis. Magni impedit quae consectetur consequuntur.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/15.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">BlackBerry names ex-Sybase executive as chief operating officer</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 20th Nov 2021</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Eaque iusto quod assumenda beatae, nesciunt aliquid. Vel, eos eligendi?</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="entry col-sm-6 col-xl-4">
                                        <div class="grid-inner">
                                            <div class="entry-image">
                                                <a href="#"><img src="images/magazine/thumb/6.jpg" alt="Image"></a>
                                            </div>
                                            <div class="entry-title title-xs nott">
                                                <h3><a href="blog-single.html">Georgian prime minister fires seven ministers in first reshuffle</a></h3>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li><i class="icon-calendar3"></i> 10th Dec 2013</li>
                                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                                </ul>
                                            </div>
                                            <div class="entry-content">
                                                <p>Magni impedit quae consectetur consequuntur adipisci veritatis modi a, officia cum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="line d-block d-lg-none"></div>

                        <div class="sidebar-widgets-wrap clearfix">

                            <div class="widget clearfix">
                                <div class="row gutter-20 col-mb-30">
                                    <div class="col-4">
                                        <a href="#" class="social-icon si-dark si-colored si-facebook mb-0" style="margin-right: 10px;">
                                            <i class="icon-facebook"></i>
                                            <i class="icon-facebook"></i>
                                        </a>
                                        <div class="counter counter-inherit d-inline-block text-smaller"><span class="d-block fw-bold" data-from="1000" data-to="58742" data-refresh-interval="100" data-speed="3000" data-comma="true"></span><small>Likes</small></div>
                                    </div>

                                    <div class="col-4">
                                        <a href="#" class="social-icon si-dark si-colored si-twitter mb-0" style="margin-right: 10px;">
                                            <i class="icon-twitter"></i>
                                            <i class="icon-twitter"></i>
                                        </a>
                                        <div class="counter counter-inherit d-inline-block text-smaller"><span class="d-block fw-bold" data-from="500" data-to="9654" data-refresh-interval="50" data-speed="2500" data-comma="true"></span><small>Followers</small></div>
                                    </div>

                                    <div class="col-4">
                                        <a href="#" class="social-icon si-dark si-colored si-rss mb-0" style="margin-right: 10px;">
                                            <i class="icon-rss"></i>
                                            <i class="icon-rss"></i>
                                        </a>
                                        <div class="counter counter-inherit d-inline-block text-smaller"><span class="d-block fw-bold" data-from="200" data-to="15475" data-refresh-interval="150" data-speed="3500" data-comma="true"></span><small>Readers</small></div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget clearfix">
                                <img class="aligncenter" src="{{ asset('template/assets/images/logopgn.png') }}" alt="Image">
                            </div>

                            <div class="widget widget_links clearfix">

                                <h4>Sektor Bantuan & Jenis Proposal</h4>

                                <div class="row col-mb-30">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li><a href="#">Bencana Alam</a></li>
                                            <li><a href="#">Pelestarian Alam</a></li>
                                            <li><a href="#">Pendidikan dan Pelatihan</a></li>
                                            <li><a href="#">Pengentasan Kemiskinan</a></li>
                                            <li><a href="#">Peningkatan Kesehatan</a></li>
                                            <li><a href="#">Prasarana dan Sarana Umum</a></li>
                                            <li><a href="#">Sarana Ibadah</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul>
                                            <li><a href="#">Bulanan</a></li>
                                            <li><a href="#">Santunan</a></li>
                                            <li><a href="#">Idul Adha</a></li>
                                            <li><a href="#">Natal</a></li>
                                            <li><a href="#">Aspirasi</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <div class="widget clearfix">

                                <h4>Twitter Feed Scroller</h4>
                                <div class="fslider customjs testimonial twitter-scroll twitter-feed" data-username="envato" data-count="2" data-animation="slide" data-arrows="false">
                                    <i class="i-plain color icon-twitter mb-0" style="margin-right: 15px;"></i>
                                    <div class="flexslider" style="width: auto;">
                                        <div class="slider-wrap">
                                            <div class="slide"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="widget clearfix">

                                <h4>Flickr Photostream</h4>
                                <div id="flickr-widget" class="flickr-feed masonry-thumbs grid-container grid-5" data-id="613394@N22" data-count="15" data-type="group" data-lightbox="gallery"></div>

                            </div>

                            <div class="widget clearfix">

                                <div class="tabs mb-0 clearfix" id="sidebar-tabs">

                                    <ul class="tab-nav clearfix">
                                        <li><a href="#tabs-1">Popular</a></li>
                                        <li><a href="#tabs-2">Recent</a></li>
                                        <li><a href="#tabs-3"><i class="icon-comments-alt me-0"></i></a></li>
                                    </ul>

                                    <div class="tab-container">

                                        <div class="tab-content clearfix" id="tabs-1">
                                            <div class="posts-sm row col-mb-30" id="popular-post-list-sidebar">
                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/3.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li><i class="icon-comments-alt"></i> 35 Comments</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/2.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li><i class="icon-comments-alt"></i> 24 Comments</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/1.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li><i class="icon-comments-alt"></i> 19 Comments</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content clearfix" id="tabs-2">
                                            <div class="posts-sm row col-mb-30" id="recent-post-list-sidebar">
                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/1.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li>10th July 2021</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/2.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li>10th July 2021</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/magazine/small/3.jpg" alt="Image"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <div class="entry-title">
                                                                <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                                                            </div>
                                                            <div class="entry-meta">
                                                                <ul>
                                                                    <li>10th July 2021</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content clearfix" id="tabs-3">
                                            <div class="posts-sm row col-mb-30" id="recent-comments-list-sidebar">
                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/icons/avatar.jpg" alt="User Avatar"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <strong>John Doe:</strong> Veritatis recusandae sunt repellat distinctio...
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/icons/avatar.jpg" alt="User Avatar"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <strong>Mary Jane:</strong> Possimus libero, earum officia architecto maiores....
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="entry col-12">
                                                    <div class="grid-inner row g-0">
                                                        <div class="col-auto">
                                                            <div class="entry-image">
                                                                <a href="#"><img class="rounded-circle" src="images/icons/avatar.jpg" alt="User Avatar"></a>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-3">
                                                            <strong>Site Admin:</strong> Deleniti magni labore laboriosam odio...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="widget clearfix">
                                <iframe src="https://player.vimeo.com/video/100299651" width="500" height="264" allow="autoplay; fullscreen" allowfullscreen></iframe>
                            </div>

                            <div class="widget clearfix">
                                <img class="aligncenter" src="images/magazine/ad.png" alt="Image">
                            </div>

                            <div class="widget clearfix">
                                <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FEnvato&amp;width=350&amp;height=240&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=499481203443583" style="border:none; overflow:hidden; width:350px; height:240px; max-width: 100% !important;"></iframe>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section><!-- #content end -->

    <!-- Footer
    ============================================= -->
    <footer id="footer" class="dark">
        <div class="container">

            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap">

                <div class="row col-mb-50">
                    <div class="col-lg-8">

                        <div class="row col-mb-50">
                            <div class="col-md-4">

                                <div class="widget clearfix">

                                    <img src="{{ asset('template/assets/images/logo-pgn-putih.png') }}" width="80px" alt="Image" class="footer-logo">

                                    <p>We believe in <strong>Simple</strong>, <strong>Creative</strong> &amp; <strong>Flexible</strong> Design Standards.</p>

                                    <div style="background: url('images/world-map.png') no-repeat center center; background-size: 100%;">
                                        <address>
                                            <strong>Headquarters:</strong><br>
                                            795 Folsom Ave, Suite 600<br>
                                            San Francisco, CA 94107<br>
                                        </address>
                                        <abbr title="Phone Number"><strong>Phone:</strong></abbr> (1) 8547 632521<br>
                                        <abbr title="Fax"><strong>Fax:</strong></abbr> (1) 11 4752 1433<br>
                                        <abbr title="Email Address"><strong>Email:</strong></abbr> info@canvas.com
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="widget widget_links clearfix">

                                    <h4>Blogroll</h4>

                                    <ul>
                                        <li><a href="https://codex.wordpress.org/">Documentation</a></li>
                                        <li><a href="https://wordpress.org/support/forum/requests-and-feedback">Feedback</a></li>
                                        <li><a href="https://wordpress.org/extend/plugins/">Plugins</a></li>
                                        <li><a href="https://wordpress.org/support/">Support Forums</a></li>
                                        <li><a href="https://wordpress.org/extend/themes/">Themes</a></li>
                                        <li><a href="https://wordpress.org/news/">Canvas Blog</a></li>
                                        <li><a href="https://planet.wordpress.org/">Canvas Planet</a></li>
                                    </ul>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="widget clearfix">
                                    <h4>Recent Posts</h4>

                                    <div class="posts-sm row col-mb-30" id="post-list-footer">
                                        <div class="entry col-12">
                                            <div class="grid-inner row">
                                                <div class="col">
                                                    <div class="entry-title">
                                                        <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                                                    </div>
                                                    <div class="entry-meta">
                                                        <ul>
                                                            <li>10th July 2021</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="entry col-12">
                                            <div class="grid-inner row">
                                                <div class="col">
                                                    <div class="entry-title">
                                                        <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                                                    </div>
                                                    <div class="entry-meta">
                                                        <ul>
                                                            <li>10th July 2021</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="entry col-12">
                                            <div class="grid-inner row">
                                                <div class="col">
                                                    <div class="entry-title">
                                                        <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                                                    </div>
                                                    <div class="entry-meta">
                                                        <ul>
                                                            <li>10th July 2021</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="row col-mb-50">
                            <div class="col-md-4 col-lg-12">
                                <div class="widget clearfix" style="margin-bottom: -20px;">

                                    <div class="row">
                                        <div class="col-lg-6 bottommargin-sm">
                                            <div class="counter counter-small"><span data-from="50" data-to="15065421" data-refresh-interval="80" data-speed="3000" data-comma="true"></span></div>
                                            <h5 class="mb-0">Total Downloads</h5>
                                        </div>

                                        <div class="col-lg-6 bottommargin-sm">
                                            <div class="counter counter-small"><span data-from="100" data-to="18465" data-refresh-interval="50" data-speed="2000" data-comma="true"></span></div>
                                            <h5 class="mb-0">Clients</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-5 col-lg-12">
                                <div class="widget subscribe-widget clearfix">
                                    <h5><strong>Subscribe</strong> to Our Newsletter to get Important News, Amazing Offers &amp; Inside Scoops:</h5>
                                    <div class="widget-subscribe-form-result"></div>
                                    <form id="widget-subscribe-form" action="include/subscribe.php" method="post" class="mb-0">
                                        <div class="input-group mx-auto">
                                            <div class="input-group-text"><i class="icon-email2"></i></div>
                                            <input type="email" id="widget-subscribe-form-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Enter your Email">
                                            <button class="btn btn-success" type="submit">Subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-3 col-lg-12">
                                <div class="widget clearfix" style="margin-bottom: -20px;">

                                    <div class="row">
                                        <div class="col-6 col-md-12 col-lg-6 clearfix bottommargin-sm">
                                            <a href="#" class="social-icon si-dark si-colored si-facebook mb-0" style="margin-right: 10px;">
                                                <i class="icon-facebook"></i>
                                                <i class="icon-facebook"></i>
                                            </a>
                                            <a href="#"><small style="display: block; margin-top: 3px;"><strong>Like us</strong><br>on Facebook</small></a>
                                        </div>
                                        <div class="col-6 col-md-12 col-lg-6 clearfix">
                                            <a href="#" class="social-icon si-dark si-colored si-rss mb-0" style="margin-right: 10px;">
                                                <i class="icon-rss"></i>
                                                <i class="icon-rss"></i>
                                            </a>
                                            <a href="#"><small style="display: block; margin-top: 3px;"><strong>Subscribe</strong><br>to RSS Feeds</small></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div><!-- .footer-widgets-wrap end -->

        </div>

        <!-- Copyrights
        ============================================= -->
        <div id="copyrights">
            <div class="container">

                <div class="row col-mb-30">

                    <div class="col-md-6 text-center text-md-start">
                        Copyrights &copy; 2020 All Rights Reserved by Canvas Inc.<br>
                        <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
                    </div>

                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end">
                            <a href="#" class="social-icon si-small si-borderless si-facebook">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-twitter">
                                <i class="icon-twitter"></i>
                                <i class="icon-twitter"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-gplus">
                                <i class="icon-gplus"></i>
                                <i class="icon-gplus"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-pinterest">
                                <i class="icon-pinterest"></i>
                                <i class="icon-pinterest"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-vimeo">
                                <i class="icon-vimeo"></i>
                                <i class="icon-vimeo"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-github">
                                <i class="icon-github"></i>
                                <i class="icon-github"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-yahoo">
                                <i class="icon-yahoo"></i>
                                <i class="icon-yahoo"></i>
                            </a>

                            <a href="#" class="social-icon si-small si-borderless si-linkedin">
                                <i class="icon-linkedin"></i>
                                <i class="icon-linkedin"></i>
                            </a>
                        </div>

                        <div class="clear"></div>

                        <i class="icon-envelope2"></i> info@canvas.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> +1-11-6541-6369 <span class="middot">&middot;</span> <i class="icon-skype2"></i> CanvasOnSkype
                    </div>

                </div>

            </div>
        </div>
        <!-- #copyrights end -->
    </footer
    ><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- JavaScripts
============================================= -->
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/plugins.min.js') }}"></script>

<!-- Footer Scripts
============================================= -->
<script src="{{ asset('js/functions.js') }}"></script>

</body>
</html>