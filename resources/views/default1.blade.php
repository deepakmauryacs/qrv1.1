<!doctype html>
<html lang="en">
   <head>
      @php $version = time(); @endphp
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Primary Meta Tags -->
      <meta name="author" content="AETHERGRID INNOVATECH PRIVATE LIMITED">
      <meta name="description" content="Digital QR offers a smart & contactless QR solution for restaurants, bakeries, stationery stores, accessories, grocery stores, supermarkets, flower shops, and gift stores. Upgrade your business with a QR menu or product catalog at just ₹99/month.">
      <meta name="keywords" content="Digital QR, QR menu, QR product listing, bakery QR menu, contactless QR, grocery QR menu, supermarket digital menu, flower shop QR, stationery QR, accessories store QR, online product catalog, QR code ordering, digital menu India">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Site Title -->
      <title>@yield('title', 'Digital QR - Smart & Contactless QR Menu & Product Listing Solution')</title>
      <!-- Open Graph / Facebook -->
      <meta property="og:title" content="Digital QR - Smart & Contactless QR Menu & Product Listing Solution">
      <meta property="og:description" content="QR menus & product catalogs for restaurants, bakeries, supermarkets, stationery stores, grocery stores, accessories, flower shops, and gift shops. Just ₹99/month!">
      <meta property="og:image" content="{{ asset('web-app/images/social-preview.png') }}">
      <meta property="og:url" content="https://www.digitalqr.in/">
      <meta property="og:type" content="website">
      <!-- Twitter Meta Tags -->
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:title" content="Digital QR - Smart & Contactless QR Menu & Product Listing Solution">
      <meta name="twitter:description" content="QR menus & product catalogs for restaurants, bakeries, supermarkets, stationery stores, grocery stores, accessories, flower shops, and gift shops. Just ₹99/month!">
      <meta name="twitter:image" content="{{ asset('web-app/images/social-preview.png') }}">
      <!-- Canonical Tag (Avoid Duplicate URL Issues) -->
      <link rel="canonical" href="https://www.digitalqr.in/">
      <!-- Favicons -->
      <link rel="shortcut icon" href="{{ asset('web-app/images/favicon.png')}}?v={{ $version }}" type="image/x-icon">
      <link rel="icon" href="{{ asset('web-app/images/favicon.png')}}?v={{ $version }}" type="image/x-icon">
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&amp;display=swap" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
      <!-- CSS Files -->
      <link href="{{ asset('web-app/css/bootstrap.min.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/flaticon.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/menu.css') }}?v={{ $version }}" rel="stylesheet">
      <link id="effect" href="{{ asset('web-app/css/dropdown-effects/fade-down.css') }}?v={{ $version }}" media="all" rel="stylesheet">
      <link href="{{ asset('web-app/css/owl.carousel.min.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/owl.theme.default.min.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/lunar.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/blue-theme.css') }}?v={{ $version }}" rel="stylesheet">
      <link href="{{ asset('web-app/css/responsive.css') }}?v={{ $version }}" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
      <script src="{{ asset('web-app/js/jquery-3.7.1.min.js') }}?v={{ $version }}"></script>
      <!-- Toastr CSS -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
      <!-- Toastr JS -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   </head>
   <body class="theme--dark">
      <!-- PRELOADER SPINNER
         ============================================= -->  
      <div id="loading" class="loading--theme">
         <div id="loading-center">
            <span class="loader"><span class="loader-inner"></span></span>
         </div>
      </div>
      <div id="page" class="page">
         <header id="header" class="tra-menu navbar-dark white-scroll">
            <div class="header-wrapper">
               <!-- MOBILE HEADER -->
               <div class="wsmobileheader clearfix">     
                  <span class="smllogo">
                  <a href="https://www.digitalqr.in">
                  <img class="lt-img" src="{{ asset('web-app/images/logo-blue.png')}}?v={{ $version }}" alt="mobile-logo">
                  <img class="dt-img" src="{{ asset('web-app/images/logo-blue-white.png')}}?v={{ $version }}" alt="mobile-logo">
                  </a>
                  </span>
                  <a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a> 
               </div>
               <!-- NAVIGATION MENU -->
               <div class="wsmainfull menu clearfix">
                  <div class="wsmainwp clearfix">
                     <!-- HEADER BLACK LOGO -->
                     <div class="desktoplogo">
                        <a href="https://www.digitalqr.in" class="logo-black">
                        <img class="lt-img" src="{{ asset('web-app/images/logo-blue.png')}}?v={{ $version }}" alt="logo">
                        <img class="dt-img" src="{{ asset('web-app/images/logo-blue-white.png')}}?v={{ $version }}" alt="logo">
                        </a>
                     </div>
                     <!-- HEADER WHITE LOGO -->
                     <div class="desktoplogo">
                        <a href="https://www.digitalqr.in" class="logo-white"><img src="{{ asset('web-app/images/logo-blue-white.png')}}?v={{ $version }}" alt="logo"></a>
                     </div>
                     <!-- MAIN MENU -->
                     <nav class="wsmenu clearfix">
                        <ul class="wsmenu-list nav-theme">
                           <!-- DROPDOWN SUB MENU -->
                           <li aria-haspopup="true">
                              <a href="#" class="h-link">Products <span class="wsarrow"></span></a>
                              <ul class="sub-menu ico-10">
                                 <li aria-haspopup="true" class="h-link"><a href="{{ url('digital-menu') }}">Digital Menu</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="{{ url('qr-code-menu') }}">Qr Code Menu</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="{{ url('admin-dashboard') }}">Admin Dashboard</a></li>
                              </ul>
                           </li>
                           <!-- DROPDOWN SUB MENU -->
                           <li aria-haspopup="true">
                              <a href="#" class="h-link">Industry <span class="wsarrow"></span></a>
                              <ul class="sub-menu ico-10">
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Food & Restaurant</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Bakery</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Stationery </a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Accessories</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Grocery & Supermarkets</a></li>
                                 <li aria-haspopup="true" class="h-link"><a href="javascript:void(0)">Flowers & Gifts</a></li>
                              </ul>
                           </li>
                           <!-- SIMPLE NAVIGATION LINK -->
                           <li class="nl-simple" aria-haspopup="true">
                              <a href="{{ url('pricing') }}" class="h-link">Pricing</a>
                           </li>
                           <!-- SIMPLE NAVIGATION LINK -->
                           <li class="nl-simple" aria-haspopup="true">
                              <a href="javascript:void(0)" class="h-link">Demo</a>
                           </li>
                           <li class="nl-simple" aria-haspopup="true">
                              <a href="{{ url('vendor/login') }}" class="h-link">Login</a>
                           </li>
                           <li class="nl-simple" aria-haspopup="true">
                              <a href="{{ url('contact-us') }}" class="h-link">Contact Us</a>
                           </li>
                           <!-- GET STARTED BUTTON -->
                           <li class="nl-simple" aria-haspopup="true">
                              <a href="{{ url('vendor/onboarding') }}" class="btn r-06 btn--theme hover--tra-coal last-link" target="_blank">Start for free</a>
                           </li>
                        </ul>
                     </nav>
                     <!-- END MAIN MENU -->
                  </div>
               </div>
               <!-- END NAVIGATION MENU -->
            </div>
            <!-- End header-wrapper -->
         </header>
         <!--Begin::Content-->
         @yield('content')
         <section id="banner-1" class="pt-100 banner-section">
            <div class="container">
               <!-- BANNER-1 WRAPPER -->
               <div class="banner-1-wrapper ba--01 bg--fixed r-16 block--shadow">
                  <div class="banner-overlay">
                     <div class="row d-flex align-items-center">
                        <!-- BANNER-1 TEXT -->
                        <div class="col-md-12 col-lg-12">
                           <div class="banner-1-txt">
                              <!-- Title -->    
                              <h4 class="h4-md">Join 10K+ Restaurants Already Using Digital QR</h4>
                              <!-- Text -->
                              <p class="p-md">Try Digital QR for free and transform your menu experience. No credit card required.</p>
                              <!-- Button -->
                              <a href="{{ url('vendor/onboarding') }}" class="btn btn-sm r-06 btn--theme hover--theme" >Get Started</a>
                              <a href="{{ url('pricing') }}" class="btn btn-sm r-06 btn--tra-coal hover--coal">View Pricing</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <footer id="footer-1" class="pt-100 footer ft-2-rows division">
            <div class="container">
               <div class="row footer-links clearfix">
                  <div class="col-lg-4">
                     <div class="footer-info">
                        <!-- Logo -->  
                        <img class="footer-logo lt-img" src="{{ asset('web-app/images/logo-blue.png')}}?v={{ $version }}" alt="footer-logo">
                        <img class="footer-logo dt-img" src="{{ asset('web-app/images/logo-blue-white.png')}}?v={{ $version }}" alt="footer-logo">
                        <!-- Text -->  
                        <p>Enhance your business with Digital QR – a seamless, contactless solution for restaurants, grocery stores, stationery shops, and gift stores.Let customers explore menus, browse products, and place orders effortlessly with just a scan.
                        </p>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="fl-2">
                        <!-- Title -->
                        <h6 class="d-title">Solutions</h6>
                        <h6 class="m-title">Solutions</h6>
                        <!-- Links -->
                        <ul class="foo-links clearfix">
                           <li>
                              <p><a href="{{ url('digital-menu') }}">Digital Menu</a></p>
                           </li>
                           <li>
                              <p><a href="{{ url('qr-code-menu') }}">Qr Code Menu</a></p>
                           </li>
                           <li>
                              <p><a href="{{ url('admin-dashboard') }}">Admin Dashboard</a></p>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <!-- FOOTER LINKS #3 -->
                     <div class="fl-3">
                        <!-- Title -->
                        <h6 class="d-title">Legal</h6>
                        <h6 class="m-title">Legal</h6>
                        <!-- Links -->
                        <ul class="foo-links clearfix">
                           <li>
                              <p><a href="{{ url('terms-and-conditions') }}">Terms of Use</a></p>
                           </li>
                           <li>
                              <p><a href="{{ url('privacy-policy') }}">Privacy Policy</a></p>
                           </li>
                        </ul>
                     </div>
                     <!-- END FOOTER LINKS #3 -->
                  </div>
                  <!-- END FOOTER LINKS #3,4 -->
                  <!-- FOOTER LINKS #5 -->
                  <div class="col-md-2">
                     <!-- FOOTER LINKS #5 -->
                     <div class="fl-5">
                        <!-- Title -->
                        <h6 class="d-title">About Us</h6>
                        <h6 class="m-title">About Us</h6>
                        <!-- Links -->
                        <ul class="foo-links clearfix">
                           <li>
                              <p><a href="{{ url('about-us') }}">About Us</a></p>
                           </li>
                           <li>
                              <p><a href="{{ url('careers')}}">Careers</a></p>
                           </li>
                           <li>
                              <p><a href="{{ url('contact-us') }}">Contact Us</a></p>
                           </li>
                           </li>
                        </ul>
                     </div>
                     <!-- END FOOTER LINKS #5 -->
                  </div>
                  <!-- END FOOTER LINKS #5 -->
               </div>
               <hr>
               <div class="bottom-footer">
                  <div class="row row-cols-1 row-cols-md-2 d-flex align-items-center">
                     <div class="col">
                        <div class="footer-copyright">
                           <p class="p-sm">&copy; 2024-2025 Digital QR. <span>All Rights Reserved</span></p>
                        </div>
                     </div>
                     <div class="col">
                        <ul class="bottom-footer-socials ico-20 text-end">
                           <li><a href="https://www.facebook.com/digitalqr"><span class="flaticon-facebook"></span></a></li>
                           <li><a href="#"><span class="flaticon-twitter-1"></span></a></li>
                           <li><a href="#"><span class="flaticon-instagram"></span></a></li>
                           <li><a href="#"><span class="flaticon-linkedin-logo"></span></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <!--End::Content-->
      <!-- JS Files -->
      <script src="{{ asset('web-app/js/bootstrap.min.js') }}?v={{ $version }}"></script>
      <script src="{{ asset('web-app/js/menu.js') }}?v={{ $version }}"></script>
      <script src="{{ asset('web-app/js/owl.carousel.min.js') }}?v={{ $version }}"></script>
      <script src="{{ asset('web-app/js/lunar.js') }}?v={{ $version }}"></script>
      <script src="{{ asset('web-app/js/custom.js') }}?v={{ $version }}"></script>
   </body>
</html>