<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="RACAi Discipleship — The digital learning and discipleship platform of Rock of Ages Christian Assembly. Equipping Believers, Raising Leaders & Refining Destinies.">
        <meta name="keywords" content="RACAi Discipleship, Rock of Ages Christian Assembly, discipleship, Christian leadership, biblical Discipleship, kingdom purpose">
        <meta name="author" content="Rock of Ages Christian Assembly">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />

        <base href="{{ url('/') }}/">
        <!-- title -->
        <title>@yield('title', 'RACAi Discipleship — Equipping Believers. Raising Leaders & Refining Destinies')</title>

        <!-- favicon -->
        <link rel="icon" href="{{ asset('assets/images/racai-blue.png') }}" type="image/png">

        <!-- bootstrap css -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />
        <!-- animate css -->
        <link rel="stylesheet" href="assets/css/animate.min.css" type="text/css" media="all" />
        <!-- swiper css -->
        <link rel="stylesheet" href="assets/css/swiper-bundle.min.css"  type="text/css" media="all" />
        <!-- meanmenu css -->
        <link rel="stylesheet" href="assets/css/meanmenu.min.css" type="text/css" media="all" />
        <!-- magnific popup css -->
        <link rel="stylesheet" href="assets/css/magnific-popup.min.css" type="text/css" media="all" />
        <!-- fullcalender css -->
        <link rel="stylesheet" href="assets/css/main.min.css" type="text/css" media="all" />
        <!-- boxicons css -->
        <link rel='stylesheet' href='assets/css/boxicons.min.css' type="text/css" media="all" />
        <!-- flaticon css -->
        <link rel='stylesheet' href='assets/css/flaticon.css' type="text/css" media="all" />
        <!-- revolution slider css -->
        <link rel='stylesheet' href='assets/css/settings.css' type="text/css" media="all" />
        <link rel='stylesheet' href='assets/css/layers.css' type="text/css" media="all" />
        <link rel='stylesheet' href='assets/css/navigation.css' type="text/css" media="all" />
        <!-- style css -->
        <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
        <!-- responsive css -->
        <link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all" />
        <!-- theme dark css -->
        <link rel="stylesheet" href="assets/css/theme-dark.css" type="text/css" media="all" />

        <!-- global scroll animations and interactive tokens -->
        <style>
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
                will-change: opacity, transform;
            }
            .animate-on-scroll.animate-fade-left {
                transform: translateX(-35px);
            }
            .animate-on-scroll.animate-fade-right {
                transform: translateX(35px);
            }
            .animate-on-scroll.animate-zoom {
                transform: scale(0.92);
            }
            .animate-on-scroll.is-visible {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }

            .delay-1 { transition-delay: 0.1s !important; animation-delay: 0.1s !important; }
            .delay-2 { transition-delay: 0.2s !important; animation-delay: 0.2s !important; }
            .delay-3 { transition-delay: 0.3s !important; animation-delay: 0.3s !important; }
            .delay-4 { transition-delay: 0.4s !important; animation-delay: 0.4s !important; }
            .delay-5 { transition-delay: 0.5s !important; animation-delay: 0.5s !important; }
            .delay-6 { transition-delay: 0.6s !important; animation-delay: 0.6s !important; }

            .hover-lift {
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .hover-lift:hover {
                transform: translateY(-7px);
                box-shadow: 0 18px 36px rgba(0, 103, 218, 0.12) !important;
            }

            .course-thumb-wrap {
                overflow: hidden;
            }
            .course-thumb-wrap .course-thumb-img {
                transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .course-racai-card:hover .course-thumb-img {
                transform: scale(1.06);
            }

            /* Hide theme switcher toggle */
            .switch-box {
                display: none !important;
            }

            .btn-nav-login {
                border: 1px solid #0067da !important;
                color: #0067da !important;
                background-color: transparent !important;
                border-radius: 6px !important;
                transition: all 0.25s ease-in-out !important;
            }
            .btn-nav-login:hover,
            .btn-nav-login:focus,
            .btn-nav-login:active {
                background-color: #0067da !important;
                color: #ffffff !important;
                border-color: #0067da !important;
                box-shadow: 0 4px 12px rgba(0, 103, 218, 0.25) !important;
            }

            @media (prefers-reduced-motion: reduce) {
                .animate-on-scroll {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: none !important;
                    animation: none !important;
                }
            }
        </style>
        @stack('styles')
        <!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- preloader -->
        <div class="preloader bg-blue">
            <div class="preloader-wrapper">
                <div class="loader-content book">
                    <figure class="page"></figure>
                    <figure class="page"></figure>
                    <figure class="page"></figure>
                </div>
                <h3>Loading RACAi Discipleship</h3>
            </div>
        </div>
        <!-- .end preloader -->
        <!-- navbar -->
        <div class="navbar-area">
            <!-- mobile menu -->
            <div class="mobile-nav">
                <a href="/" class="mobile-brand d-inline-flex align-items-center gap-2">
                    <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi Discipleship" class="logo logo1" style="max-height: 48px; width: auto; object-fit: contain;">
                    <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi Discipleship" class="logo2" style="max-height: 48px; width: auto; object-fit: contain;">
                </a>
                <div class="navbar-option">
                    <div class="navbar-option-item navbar-option-dots dropdown">
                        <ul class="dropdown-menu navbar-dots-dropdown">
                            <li class="dropdown-item">
                                <div class="navbar-option-item navbar-option-cart">
                                    <div class="navbar-option-item navbar-option-search dropdown">
                                        <button type="button" id="search1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-search"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="search1">
                                            <form method="GET" action="{{ route('courses.index') }}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="flaticon-search"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="search" class="form-control" placeholder="Search teachings & courses...">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li> 
                        </ul>
                    </div>
                     
                    <div class="navbar-option-item navbar-option-search dropdown mobile-hide">
                        <button type="button" id="search" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="flaticon-search"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="search">
                            <form method="GET" action="{{ route('courses.index') }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="flaticon-search"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="search" class="form-control" placeholder="Search teachings & courses...">
                                </div>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- desktop menu -->
            <div class="main-nav">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand d-inline-flex align-items-center gap-2" href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi" class="logo logo1" style="max-height: 54px; width: auto; object-fit: contain;">
                            <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi" class="logo2" style="max-height: 54px; width: auto; object-fit: contain;">
                        </a>
                        <div class="navbar-search">
                            <form method="GET" action="{{ route('courses.index') }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="flaticon-search"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="search" class="form-control" placeholder="Search courses & teachings..." value="{{ request('search') }}">
                                </div>
                            </form>
                        </div>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">HOME</a>
                                </li> 
                                <li class="nav-item">
                                    <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">COURSES</a>
                                </li> 
                                <li class="nav-item">
                                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">ABOUT</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">CONTACT</a>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar-option">
                            <div class="navbar-option-item navbar-option-authentication">
                                @auth
                                    <a href="{{ auth()->user()->isAdmin() || auth()->user()->isTutor() ? '/admin' : route('student.dashboard') }}" class="btn main-btn text-nowrap">Dashboard</a>
                                @else
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('login') }}" class="btn btn-nav-login text-nowrap py-2 px-3 fw-semibold d-none d-xl-inline-block">Login</a>
                                        <a href="{{ route('register') }}" class="btn main-btn text-nowrap">Start Learning</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- .end navbar -->

        @yield('content')
           
        <!-- footer -->
        <footer>
            <div class="footer-upper pt-100 pb-80 bg-blue">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="footer-content-item">
                                <div class="footer-logo mb-3">
                                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-3 text-decoration-none">
                                        <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi" style="max-height: 64px; width: auto; object-fit: contain;">
                                        <div>
                                            <span class="d-block fw-bold text-uppercase letter-spacing-2" style="font-size: 1.15rem; color: #fbbf24;">Discipleship</span>
                                            <span class="small text-white-50 d-none d-sm-block" style="font-size: 0.72rem; letter-spacing: 0.5px;">ROCK OF AGES CHRISTIAN ASSEMBLY</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="footer-details footer-address-info">
                                    <p class="text-white opacity-85 mb-3" style="line-height: 1.6;">
                                        <strong>Equipping Believers. Raising Leaders. Transforming Lives.</strong><br>
                                        The digital learning and discipleship platform of Rock of Ages Christian Assembly.
                                    </p>
                                    <div class="footer-address-info-item">
                                        <h4>Assembly & Support</h4>
                                        <p class="footer-email"><a href="mailto:support@racaitraining.org"><span class="__cf_email__">support@racaitraining.org</span></a></p>
                                    </div>
                                    <div class="footer-address-info-item">
                                        <p class="footer-availability"><span>Rock of Ages Christian Assembly</span> (RACAi)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="footer-right pl-lg-5">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="footer-content-list footer-content-item">
                                            <div class="footer-content-title">
                                                <h3>Platform</h3>
                                            </div>
                                            <ul class="footer-details footer-list"> 
                                                <li><a href="{{ url('/') }}">Home</a></li>
                                                <li><a href="{{ route('courses.index') }}">Courses</a></li>
                                                <li><a href="{{ route('about') }}">About Us</a></li>
                                                <li><a href="{{ route('contact') }}">Contact</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="footer-content-list footer-content-item">
                                            <div class="footer-content-title">
                                                <h3>Grow in Faith</h3>
                                            </div>
                                            <ul class="footer-details footer-list"> 
                                                <li><a href="{{ auth()->check() ? route('student.dashboard') : route('register') }}">Start Learning</a></li>
                                                <li><a href="{{ url('/#journey') }}">Learning Journey</a></li>
                                                <li><a href="{{ url('/#word') }}">Built Around the Word</a></li>
                                                <li><a href="{{ url('/#stages') }}">Stages of Growth</a></li>
                                                <li><a href="{{ route('faqs') }}">FAQ</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="footer-content-list footer-content-item">
                                            <div class="footer-content-title">
                                                <h3>Legal & Info</h3>
                                            </div>
                                            <ul class="footer-details footer-list"> 
                                                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                                                <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                                                <li><a href="{{ auth()->check() ? route('student.dashboard') : route('login') }}">Login</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-lower bg-off-white">
                <div class="background-shapes">
                    <div class="background-shape-item">
                        <img src="assets/images/shapes/curved-line.png" alt="line">
                    </div>
                    <div class="background-shape-item">
                        <img src="assets/images/shapes/half-circle-shape.png" alt="line">
                    </div>
                    <div class="background-shape-item">
                        <img src="assets/images/shapes/animate-shape-1.png" alt="line">
                    </div>
                </div>
                <div class="container">
                    <div class="footer-lower-grid">
                        <div class="footer-lower-item footer-lower-info">
                            <div class="footer-copyright-text">
                                <p>© {{ date('Y') }} RACAi Discipleship. All rights reserved. Rock of Ages Christian Assembly.</p>
                            </div>
                        </div>
                        <div class="footer-lower-item">
                            <ul class="social-list">
                                <li><a href="https://facebook.com" target="_blank" rel="noopener"><img src="assets/images/facebook.png" alt="Facebook"></a></li>
                                <li><a href="https://twitter.com" target="_blank" rel="noopener"><img src="assets/images/twitter.png" alt="Twitter"></a></li>
                                <li><a href="https://instagram.com" target="_blank" rel="noopener"><img src="assets/images/instagram.png" alt="Instagram"></a></li>
                                <li><a href="https://youtube.com" target="_blank" rel="noopener"><img src="assets/images/youtube.png" alt="YouTube"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- .end footer -->

        <!-- scroll-top -->
        <div class="scroll-top" id="scrolltop">
            <div class="scroll-top-inner">
                <span><i class="flaticon-up-arrow"></i></span>
            </div>
        </div>
        <!-- .end scroll-top -->

        <!-- essential js -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <!-- magnific popup js -->
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <!-- swiper js -->
        <script src="assets/js/swiper-bundle.min.js"></script>
        <!-- counter js -->
        <script src="assets/js/jquery.waypoints.min.js"></script>
        <script src="assets/js/jquery.counterup.min.js"></script>
        <!-- fullcalender js -->
        <script src="assets/js/moment.js"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/jquery-ui.js"></script>
        <!-- isotope js -->
        <script src="assets/js/isotope.pkgd.min.js"></script>
        <!-- revolution slider js -->
        <script src="assets/js/jquery.themepunch.revolution.min.js"></script>
        <script src="assets/js/jquery.themepunch.tools.min.js"></script>
        <!-- slider revolution extension scripts. only needed for local testing -->
        <script src="assets/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.carousel.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.kenburn.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.migration.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.parallax.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="assets/js/extensions/revolution.extension.video.min.js"></script>
        <!-- form ajazchimp js -->
        <script src="assets/js/jquery.ajaxchimp.min.js"></script>
        <!-- form validator js  -->
        <script src="assets/js/form-validator.min.js"></script>
        <!-- contact form js -->
        <script src="assets/js/contact-form-script.js"></script>
        <!-- meanmenu js -->
        <script src="assets/js/jquery.meanmenu.min.js"></script>
        <!-- main js -->
        <script src="assets/js/script.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var pinSetupModal = new bootstrap.Modal(document.getElementById('pinSetupModal'));
                pinSetupModal.show();
            });

            // Global Submit Button Spinner Loader
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form.tagName === 'FORM') {
                    if (form.classList.contains('no-spinner')) return;
                    if (form.checkValidity && !form.checkValidity()) return;

                    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                    submitButtons.forEach(button => {
                        // Store original value
                        button.setAttribute('data-original-disabled', button.disabled);
                        button.disabled = true;

                        if (button.tagName === 'BUTTON') {
                            if (button.querySelector('.spinner-border')) return;
                            const spinner = document.createElement('span');
                            spinner.className = 'spinner-border spinner-border-sm me-2';
                            spinner.setAttribute('role', 'status');
                            spinner.setAttribute('aria-hidden', 'true');
                            button.prepend(spinner);
                        } else if (button.tagName === 'INPUT') {
                            button.setAttribute('data-original-value', button.value);
                            button.value = 'Processing...';
                        }
                    });

                    // Safety fallback: re-enable buttons after 8 seconds in case of downloads or interceptors
                    setTimeout(() => {
                        submitButtons.forEach(button => {
                            button.disabled = button.getAttribute('data-original-disabled') === 'true';
                            const spinner = button.querySelector('.spinner-border');
                            if (spinner) spinner.remove();
                            if (button.tagName === 'INPUT' && button.hasAttribute('data-original-value')) {
                                button.value = button.getAttribute('data-original-value');
                            }
                        });
                    }, 8000);
                }
            });

            // Global Scroll-Triggered Animation Engine
            (function() {
                function initScrollAnimations() {
                    const scrollElements = document.querySelectorAll('.animate-on-scroll, [data-animation]');
                    if (!scrollElements.length) return;

                    // Automatically assign cascading stagger delays if inside a .stagger-group
                    document.querySelectorAll('.stagger-group').forEach(group => {
                        const items = group.querySelectorAll('.animate-on-scroll, [data-animation]');
                        items.forEach((item, idx) => {
                            if (!item.style.animationDelay && !item.getAttribute('data-delay')) {
                                const delay = ((idx % 4) * 0.12).toFixed(2) + 's';
                                item.style.animationDelay = delay;
                                item.style.transitionDelay = delay;
                            }
                        });
                    });

                    if ('IntersectionObserver' in window) {
                        const observer = new IntersectionObserver((entries, obs) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    const el = entry.target;
                                    const anim = el.getAttribute('data-animation');
                                    const delay = el.getAttribute('data-delay');
                                    if (delay) {
                                        el.style.animationDelay = delay;
                                        el.style.transitionDelay = delay;
                                    }
                                    if (anim) {
                                        el.classList.add('animate__animated', anim);
                                    }
                                    el.classList.add('is-visible');
                                    obs.unobserve(el);
                                }
                            });
                        }, {
                            threshold: 0.08,
                            rootMargin: '0px 0px -30px 0px'
                        });

                        scrollElements.forEach(el => observer.observe(el));
                    } else {
                        scrollElements.forEach(el => {
                            const anim = el.getAttribute('data-animation');
                            if (anim) el.classList.add('animate__animated', anim);
                            el.classList.add('is-visible');
                        });
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initScrollAnimations);
                } else {
                    initScrollAnimations();
                }
            })();
        </script>
    </body>
</html>