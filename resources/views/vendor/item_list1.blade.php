
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Delici - Restaurants HTML Template - Menus List</title>
<!-- Stylesheets -->
<link href="{{ asset('web/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{ asset('web/css/style.css')}}" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('web/images/favicon.png')}}" type="image/x-icon">
<link rel="icon" href="{{ asset('web/images/favicon.png')}}" type="image/x-icon">
<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link href="{{ asset('web/css/responsive.css')}}" rel="stylesheet">

</head>

<body>
  <div class="page-wrapper"> 
  
    <!-- Preloader -->
    <div class="loader-wrap">
        <div class="preloader">
            <div class="preloader-close">x</div>
            <div id="handle-preloader" class="handle-preloader">
                <div class="animation-preloader">
                    <div class="spinner"></div>
                    <div class="txt-loading">
                        <span data-text-preloader="D" class="letters-loading">
                            D
                        </span>
                        <span data-text-preloader="E" class="letters-loading">
                            E
                        </span>
                        <span data-text-preloader="L" class="letters-loading">
                            L
                        </span>
                        <span data-text-preloader="I" class="letters-loading">
                            I
                        </span>
                        <span data-text-preloader="C" class="letters-loading">
                            C
                        </span>
                        <span data-text-preloader="I" class="letters-loading">
                            I
                        </span>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Main Header-->
    <header class="main-header">
        <div class="header-top">
            <div class="auto-container">
                <div class="inner clearfix">
                    <div class="top-left clearfix">
                        <ul class="top-info clearfix">
                            <li><i class="icon far fa-map-marker-alt"></i> Restaurant St, Delicious City, London 9578, UK</li>
                            <li><i class="icon far fa-clock"></i> Daily : 8.00 am to 10.00 pm</li>
                        </ul>
                    </div>
                    <div class="top-right clearfix">
                        <ul class="top-info clearfix">
                            <li><a href="tel:+11234567890"><i class="icon far fa-phone"></i> +1 123 456 7890</a></li>
                            <li><a href="mailto:booking@restaurant.com"><i class="icon far fa-envelope"></i> booking@restaurant.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Upper -->
        <div class="header-upper">        
            <div class="auto-container">
                <!-- Main Box -->
                <div class="main-box clearfix">
                    <!--Logo-->
                    <div class="logo-box">
                         <div class="logo"><a href="index.html" title="Delici - Restaurants HTML Template"><img src="{{ asset('web/images/logo.png')}}" alt="" title="Delici - Restaurants HTML Template"></a></div>
                    </div>

                    <div class="nav-box clearfix">
                        <!--Nav Outer-->
                        <div class="nav-outer clearfix">         
                            <nav class="main-menu">
                                <ul class="navigation clearfix">
                                    <li class=""><a href="index.html">Home</a>
                                    </li>
                                    <li><a href="#menu-section" class="scroll-to">Menus</a></li>
                                    <li><a href="#about-section" class="scroll-to">About Us</a></li>
                                    <li><a href="contact-us.html">Contact</a></li>
                                </ul>
                            </nav>
                            <!-- Main Menu End-->
                        </div>
                        <!--Nav Outer End-->

                        <div class="links-box clearfix">
                            <div class="link link-btn">
                                <a href="reservation-opentable.html" class="theme-btn btn-style-one clearfix">
                                    <span class="btn-wrap">
                                        <span class="text-one">find a table</span>
                                        <span class="text-two">find a table</span>
                                    </span>
                                </a>
                            </div>
                            <div class="link info-toggler">
                                <button class="info-btn">
                                    <span class="hamburger">
                                        <span class="top-bun"></span>
                                        <span class="meat"></span>
                                        <span class="bottom-bun"></span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Nav Toggler -->
                        <div class="nav-toggler">
                            <button class="hidden-bar-opener">
                                <span class="hamburger">
                                    <span class="top-bun"></span>
                                    <span class="meat"></span>
                                    <span class="bottom-bun"></span>
                                </span>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </header>
    <!--End Main Header -->

    
    <!--Menu Backdrop-->
    <div class="menu-backdrop"></div>

    <!-- Hidden Navigation Bar -->
    <section class="hidden-bar">
        <!-- Hidden Bar Wrapper -->
        <div class="inner-box">
            <div class="cross-icon hidden-bar-closer"><span class="far fa-close"></span></div>
            <div class="logo-box"><a href="index.html" title="Delici - Restaurants HTML Template"><img src="{{ asset('web/images/resource/sidebar-logo.png')}}" alt="" title="Delici - Restaurants HTML Template"></a></div>
            
            <!-- .Side-menu -->
            <div class="side-menu">
                 <ul class="navigation clearfix">
                    <li class=""><a href="index.html">Home</a>
                    </li>
                    <li class="current dropdown"><a href="menu-list.html">Menus</a>
                        <ul>
                            <li><a href="menu-list-1.html">Menu List 1</a></li>
                            <li><a href="menu-list-2.html">Menu List 2</a></li>
                            <li><a href="menu-list-3.html">Menu List 3</a></li>
                            <li><a href="menu-list-4.html">Menu List 4</a></li>
                        </ul>
                    </li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="our-chef.html">Our chefs</a></li>
                    <li class="dropdown"><a href="#">Pages</a>
                        <ul>
                            <li><a href="#">Dropdown Menu 1</a></li>
                            <li><a href="#">Dropdown Menu 2</a></li>
                            <li><a href="#">Dropdown Menu 3</a></li>
                            <li class="dropdown"><a href="#">Dropdown Menu 4</a>
                                <ul>
                                    <li><a href="#">Dropdown Menu level 2</a></li>
                                    <li><a href="#">Dropdown Menu level 2</a></li>
                                    <li><a href="#">Dropdown Menu Level 3</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown Lorem 5</a></li>
                        </ul>
                    </li>
                    <li><a href="contact-us.html">Contact</a></li>
                </ul>
            </div><!-- /.Side-menu -->
            
            <h2>Visit Us</h2>
            <ul class="info">
                <li>Restaurant St, Delicious City, <br>London 9578, UK</li>
                <li>Open: 9.30 am - 2.30pm</li>
                <li><a href="mailto:booking@domainame.com">booking@domainame.com</a></li>
            </ul>
            <div class="separator"><span></span></div>
            <div class="booking-info">
                <div class="bk-title">Booking request</div>
                <div class="bk-no"><a href="tel:+88-123-123456">+88-123-123456</a></div>
            </div>
        
        </div><!-- / Hidden Bar Wrapper -->
    </section>
    <!-- / Hidden Bar -->

    <!--Info Back Drop-->
    <div class="info-back-drop"></div>
    
    <!-- Hidden Bar -->
    <section  class="info-bar">
        <div class="inner-box">
            <div class="cross-icon"><span class="far fa-close"></span></div>
            <div class="logo-box"><a href="index.html" title="Delici - Restaurants HTML Template"><img src="{{ asset('web/images/resource/sidebar-logo.png')}}" alt="" title="Delici - Restaurants HTML Template"></a></div>
            <div class="image-box"><img src="{{ asset('web/images/resource/sidebar-image.jpg')}}" alt="" title=""></div>

            <h2>Visit Us</h2>
            <ul class="info">
                <li>Restaurant St, Delicious City, <br>London 9578, UK</li>
                <li>Open: 9.30 am - 2.30pm</li>
                <li><a href="mailto:booking@domainame.com">booking@domainame.com</a></li>
            </ul>
            <div class="separator"><span></span></div>
            <div class="booking-info">
                <div class="bk-title">Booking request</div>
                <div class="bk-no"><a href="tel:+88-123-123456">+88-123-123456</a></div>
            </div>
        </div>
    </section>
    <!--End Hidden Bar -->

    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="image-layer" style="background-image: url(images/background/banner-image-2.jpg);"></div>
        <div class="auto-container">
            <div class="inner">
                <div class="subtitle"><span>delicious & amazing</span></div>
                <div class="pattern-image"><img src="{{ asset('web/images/icons/separator.svg')}}" alt="" title=""></div>
                <h1><span>Our Menu 3</span></h1>
            </div>
        </div>
    </section>
    <!--End Banner Section -->
    @if(count($menuCategories) > 0)
        @foreach($menuCategories as $category)
            @if($category->vendorMenus->count() > 0)
            <section  id="menu-section" class="menu-two">
                <div class="auto-container">
                    <div class="title-box centered">
                        <div class="subtitle"><span>{{ $category->description ?? 'Delicious Items' }}</span></div>
                        <div class="pattern-image">
                            <img src="{{ asset('web/images/icons/separator.svg') }}" alt="">
                        </div>
                        <h3>{{ $category->name }}</h3>
                    </div>
                    <div class="row clearfix">
                        @foreach($category->vendorMenus as $menu)
                        <div class="menu-col col-lg-6 col-md-12 col-sm-12">
                            <div class="inner">
                                <!-- Block -->
                                <div class="dish-block">
                                    <div class="inner-box">
                                        @if($menu->image)
                                        <div class="dish-image">
                                            <a href="#"><img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" style="object-fit: cover;"></a>
                                        </div>
                                        @else
                                        <div class="dish-image">
                                            <a href="#"><img src="https://kalanidhithemes.com/live-preview/landing-page/delici/all-demo/Delici-Defoult/images/resource/drink-6.png" alt="{{ $menu->name }}" style="object-fit: cover;"></a>
                                        </div>
                                        @endif
                                        <div class="title clearfix">
                                            <div class="ttl clearfix">
                                                <h5><a href="#">{{ $menu->name }}</a></h5>
                                            </div>
                                           <div class="price">
                                               
                                                    <span style="font-size: 15px;"> ₹{{ $menu->price_full }} / ₹{{ $menu->price_half }}</span>
                                               
                                                   
                                               
                                            </div>

                                        </div>
                                        <div class="text desc">
                                            <a href="#">{{ $menu->description }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @endforeach
    @else
        <p>No menu items available.</p>
    @endif

    <!-- About Us Section -->
    <section id="about-section" class="about-us">
        <div class="auto-container">
            <div class="row clearfix">
                
                <!-- Content Column -->
                <div class="content-col col-lg-12 col-md-12 col-sm-12">
                    <div class="inner">
                        <div class="title-box">
                            <div class="subtitle"><span>Who We Are</span></div>
                            <div class="pattern-image">
                                <img src="{{ asset('web/images/icons/separator.svg') }}" alt="">
                            </div>
                            <h2>About Our Restaurant</h2>
                        </div>
                        <div class="text">
                            <p>Welcome to our restaurant, where we offer a wide variety of delicious dishes crafted with the finest ingredients. Our chefs bring their expertise and passion to every plate, ensuring an unforgettable dining experience.</p>
                            <p>Whether you're looking for a cozy dinner, a family outing, or a special celebration, our restaurant provides the perfect setting with a warm ambiance and exceptional service.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!--Reservation Section-->
    <section class="reserve-section style-two">
        <div class="image-layer" style="background-image: url(images/background/image-10.jpg);"></div>
        <div class="auto-container">
            <div class="outer-box">
                <div class="row clearfix">
                    <div class="reserv-col col-lg-8 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="title">
                                <h2>Online Reservation</h2>
                                <div class="request-info">Booking request <a href="#">+88-123-123456</a> or fill out the order form</div>
                            </div>
                            <div class="default-form reservation-form">
                                <form method="post" action="https://kalanidhithemes.com/live-preview/landing-page/delici/all-demo/Delici-Defoult/index.html">
                                    <div class="row clearfix">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <input type="text" name="fieldname" value="" placeholder="Your Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <input type="text" name="fieldname" value="" placeholder="Phone Number" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-user"></span>
                                                <select class="l-icon">
                                                    <option>1 Person</option>
                                                    <option>2 Person</option>
                                                    <option>3 Person</option>
                                                    <option>4 Person</option>
                                                    <option>5 Person</option>
                                                    <option>6 Person</option>
                                                    <option>7 Person</option>
                                                </select>
                                                <span class="arrow-icon far fa-angle-down"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-calendar"></span>
                                                <input class="l-icon datepicker" type="text" name="fieldname" value="" placeholder="DD-MM-YYYY" required readonly>
                                                <span class="arrow-icon far fa-angle-down"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-clock"></span>
                                                <select class="l-icon">
                                                    <option>08 : 00 am</option>
                                                    <option>09 : 00 am</option>
                                                    <option>10 : 00 am</option>
                                                    <option>11 : 00 am</option>
                                                    <option>12 : 00 pm</option>
                                                    <option>01 : 00 pm</option>
                                                    <option>02 : 00 pm</option>
                                                    <option>03 : 00 pm</option>
                                                    <option>04 : 00 pm</option>
                                                    <option>05 : 00 pm</option>
                                                    <option>06 : 00 pm</option>
                                                    <option>07 : 00 pm</option>
                                                    <option>08 : 00 pm</option>
                                                    <option>09 : 00 pm</option>
                                                    <option>10 : 00 pm</option>
                                                </select>
                                                <span class="arrow-icon far fa-angle-down"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="field-inner">
                                                <textarea name="fieldname" placeholder="Message" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="field-inner">
                                                <button type="submit" class="theme-btn btn-style-one clearfix">
                                                    <span class="btn-wrap">
                                                        <span class="text-one">book a table</span>
                                                        <span class="text-two">book a table</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="info-col col-lg-4 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="img-layer" style="background-image: url(images/background/image-11.jpg);"></div>
                            <div class="title">
                                <div class="subtitle">hot deal</div>
                                <h5>Lunch & Dinner Specials</h5>
                            </div>
                            <div class="data">
                                <div class="discount-info">
                                    <div class="s-ttl">up to</div>
                                    <div class="num">45%</div>
                                    <div class="s-ttl">discount</div>
                                </div>
                                <div class="instruction">
                                    • Not valid for online order <br>
                                    • Non-refundable <br>
                                    • Offer end on 25 Jan <br>
                                </div>
                                <div class="link-box">
                                    <a href="reservation-opentable.html" class="theme-btn btn-style-one clearfix">
                                        <span class="btn-wrap">
                                            <span class="text-one">book now</span>
                                            <span class="text-two">book now</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--Main Footer-->
    <footer class="main-footer">
        <div class="footer-bottom">
            <div class="auto-container">
               <div class="copyright">
                    &copy; <span id="currentYear"></span> Restaurant. All Rights Reserved |
                    Proudly Made in India 🇮🇳 | Made by <a href="https://digitalqr.in/" target="_blank">Digital QR</a>
                </div>

                <script>
                    document.getElementById('currentYear').textContent = new Date().getFullYear();
                </script>
            </div>
        </div>
    </footer>

</div>
<!--End pagewrapper--> 

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon fa fa-angle-up"></span></div>

<script src="{{ asset('web/js/jquery.js')}}"></script>
<script src="{{ asset('web/js/popper.min.js')}}"></script>
<script src="{{ asset('web/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('web/js/jquery-ui.js')}}"></script>
<script src="{{ asset('web/js/jquery.fancybox.js')}}"></script>
<script src="{{ asset('web/js/swiper.js')}}"></script>
<script src="{{ asset('web/js/owl.js')}}"></script>
<script src="{{ asset('web/js/appear.js')}}"></script>
<script src="{{ asset('web/js/wow.js')}}"></script>
<script src="{{ asset('web/js/custom-script.js')}}"></script>
</body>
</html>