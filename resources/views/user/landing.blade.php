<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="gym.png" type="">

    <title>NutriGym</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('gymlife-master/css/style.css') }}">

</head>
<style>
    .section-box {
        padding: 50px 20px;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);

    }

    .section-title {
        color: #f36100;
        font-weight: 700;
        font-size: 42px;
        margin-bottom: 15px;
    }

    .section-desc {
        font-size: 18px;
        color: #555;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .section-img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .section-img:hover {
        transform: scale(1.03);
    }

    .primary-btn {
        padding: 12px 30px;
        background-color: #f36100;
        color: white;
        border-radius: 25px;
        text-transform: uppercase;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s;
    }

    .primary-btn:hover {
        background-color: #d64d00;
    }
</style>

<body>


    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><a href="./about-us.html">About Us</a></li>
                <li class="{{ request()->routeIs('subscriptions.show') ? 'active' : '' }}"><a href="{{route('subscriptions.show')}}">My Subscriptions</a></li>
                <li><a href="#">My Appointments</a></li>
                <li><a href="./team.html">Our Team</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <h1 style="color: white">Nutri<span style="color:#f36100">Gym</span></h1>
                    </div>
                </div>
                <div class="col-lg-6 mt-5">
                    <nav class="nav-menu">
                        <ul>
                            <li class="{{ request()->routeIs('user.home') ? 'active' : '' }}"><a
                                    href="{{ route('user.home') }}">Home</a></li>
                            @guest
                                <li class="{{ request()->routeIs('registration') ? 'active' : '' }}"><a
                                        href="{{ route('registration') }}">Sign Up</a></li>
                                <li class="{{ request()->routeIs('login') ? 'active' : '' }}"><a
                                        href="{{ route('login') }}">Login</a></li>
                            @endguest
                            @auth
                            <li class="{{ request()->routeIs('subscriptions.show') ? 'active' : '' }}"><a href="{{route('subscriptions.show')}}">My Subscriptions</a></li>
                            <li class="{{ request()->routeIs('appointments.show') ? 'active' : '' }}"><a href="{{route('appointments.show')}}">My Appointments</a></li>
                                <li class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                                    <a class="nav-link "
                                        href="{{ route('user.profile') }}">
                                        <i class="fa-solid fa-user mr-1"></i>
                                        {{ explode(' ', auth()->user()->name)[0] }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}">
                                        <i class="fa-solid fa-right-from-bracket mr-1"></i>Log Out
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </nav>
                </div>

            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="{{ asset('gymlife-master/img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                                <a href="#" class="primary-btn">Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="{{ asset('gymlife-master/img/hero/hero-2.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                                <a href="#" class="primary-btn">Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span>Why Choose Us?</span>
                        <h2>Empowering Your Health Journey</h2>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Top-Tier Facilities</h4>
                        <p>Access modern gyms and equipment designed to enhance your workouts and maximize your
                            progress.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Personalized Nutrition</h4>
                        <p>Connect with expert nutritionists who tailor meal plans to your lifestyle and health goals.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Certified Professionals</h4>
                        <p>Work with licensed trainers and therapists to safely improve your strength, flexibility, and
                            recovery.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
                        <h4>Tailored Experience</h4>
                        <p>From fitness to therapy to healthy food — everything is customized to support your personal
                            journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ChoseUs Section End -->

    <!-- Classes Section Begin -->

    <!-- Gyms (Image Left, Text Right) -->
    <section class="classes-section spad">
        <div class="container section-box">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('gymlife-master/img/gallery/gyms.webp') }}" alt="Gyms"
                        class="section-img">
                </div>
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="section-title">Gyms</h2>
                    <p class="section-desc">
                        Discover the best gyms near you and start your fitness journey today with expert coaches and
                        modern equipment.
                    </p>
                    <a href="{{ route('gyms.index') }}" class="primary-btn">See
                        More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Physical Therapy (Image Right, Text Left) -->
    <section class="classes-section spad">
        <div class="container section-box">
            <div class="row align-items-center flex-md-row-reverse">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('gymlife-master/img/gallery/Physical-Therapy.jpg') }}" alt="Physical Therapy"
                        class="section-img">
                </div>
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="section-title">Physical Therapy Clinics</h2>
                    <p class="section-desc">
                        Rehabilitate your body with our trusted therapists using proven treatment techniques in a calm
                        environment.
                    </p>
                    <a href="{{ url('/categories/' . str_replace(' ', '-', "Physical Therapy Clinics"))  }}" class="primary-btn">See
                        More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Nutrition (Center Layout) -->
    <section class="classes-section spad">
        <div class="container section-box text-center">
            <img src="{{ asset('gymlife-master/img/gallery/nutrition.jpg') }}" alt="Nutrition"
                class="section-img mb-4" style="max-width: ">
            <h2 class="section-title">Nutrition Clinics</h2>
            <p class="section-desc">
                Personalized diet plans, healthy lifestyle guidance, and expert nutrition advice to support your fitness
                goals.
            </p>
            <a href="{{ url('/categories/' . str_replace(' ', '-', "Nutrition Clinics"))  }}" class="primary-btn">See More</a>
        </div>
    </section>

    <!-- Restaurants (Image Left, Text Right) -->
    <section class="classes-section spad">
        <div class="container section-box">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('gymlife-master/img/gallery/resturant.webp') }}" alt="Restaurants"
                        class="section-img">
                </div>
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="section-title">Restaurants</h2>
                    <p class="section-desc">
                        Explore healthy and delicious meal options in restaurants that understand fitness-focused diets.
                    </p>
                    <a href="{{ route('categories', parameters: ['name' => 'Restaurants']) }}"
                        class="primary-btn">See More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Store (Image Right, Text Left) -->
    <section class="classes-section spad">
        <div class="container section-box">
            <div class="row align-items-center flex-md-row-reverse">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('gymlife-master/img/gallery/store.jpg') }}" alt="Store"
                        class="section-img">
                </div>
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="section-title">Store</h2>
                    <p class="section-desc">
                        Shop your favorite fitness gear, health supplements, and wellness products in our exclusive
                        store.
                    </p>
                    <a href="{{ route('categories', parameters: ['name' => 'Store']) }}" class="primary-btn">See
                        More</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>333 Middle Winchendon Rd, Rindge,<br /> NH 03461</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>125-711-811</li>
                            <li>125-668-886</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>Support.gymcenter@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <div class="fa-logo">
                            <a href="#"><img src="{{ asset('gymlife-master/img/logo.png') }}"
                                    alt=""></a>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore dolore magna aliqua endisse ultrices gravida lorem.</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa  fa-envelope-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Useful links</h4>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Classes</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">My account</a></li>
                            <li><a href="#">Subscribe</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Tips & Guides</h4>
                        <div class="fw-recent">
                            <h6><a href="#">Physical fitness may help prevent depression, anxiety</a></h6>
                            <ul>
                                <li>3 min read</li>
                                <li>20 Comment</li>
                            </ul>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Fitness: The best exercise to lose belly fat and tone up...</a></h6>
                            <ul>
                                <li>3 min read</li>
                                <li>20 Comment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <!-- Js Plugins -->
    <script src="{{ asset('gymlife-master/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('gymlife-master/js/main.js') }}"></script>
    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>




</body>

</html>
