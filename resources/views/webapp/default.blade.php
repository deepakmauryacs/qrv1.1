<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title> {{ $settings->store_name }} - Our Menu</title>
     
      <meta name="robots" content="noodp"/>
      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400;1,700&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" id="dina-bootstrap-css-css"  href="{{ asset('qr-webapp/css/bootstrap/css/bootstrap.min.css')}}" type="text/css" media='all' />
      <!-- Font Awesome Icons CSS -->
      <link rel="stylesheet" id="dina-font-awesome-css"  href="{{ asset('qr-webapp/css/fontawesome/css/font-awesome.min.css')}}" type='text/css' media='all' />
      <!-- Main CSS File -->
      <link rel="stylesheet" id="dina-style-css-css"  href="{{ asset('qr-webapp/style.css')}}" type="text/css" media="all" />
      <!-- favicons -->
      <link rel="icon" href="{{ asset('qr-webapp/images/icons/digital-qr-favicon.png')}}" sizes="32x32" />
      <link rel="icon" href="{{ asset('qr-webapp/images/icons/digital-qr-favicon.png')}}" sizes="192x192" />
      <link rel="apple-touch-icon-precomposed" href="{{ asset('qr-webapp/images/icons/digital-qr-favicon.png')}}" />
      <script  src="{{ asset('qr-webapp/js/jquery.js')}}"></script>
      <style type="text/css">
         .topSingleBkg {
           width: 100%;
           height: 170PX;
           display: block;
           overflow: hidden;
           position: relative;
           margin-bottom: 72px;
         }
         .inner-desc {
           position: absolute;
           z-index: 4;
           text-align: center;
           padding: 0 15px;
           width: 100%;
           top: 75%;
           font-size: 30px;
           font-weight: bold;
         }
      </style>
   </head>
   <body class="body-header1" >
      <!-- MOBILE MENU -->
      <div class="mask-nav-2">
         <!-- MENU -->
         <nav class="navbar navbar-2 nav-mobile">
            <div class="nav-holder nav-holder-2">
               <ul id="menu-menu-2" class="menu-nav-2">
                  <li class="menu-item"><a href="{{ url('items') }}/{{ $vendor->code }}">Home</a></li>
                  <li class="menu-item"><a href="{{ url('items') }}/{{ $vendor->code }}">Menu</a></li>
                  <li class="menu-item"><a href="reservation.html">Reservation</a></li>
                  <li class="menu-item"><a href="{{ url('contact') }}/{{ $vendor->code }}">Contact</a></li>
               </ul>
            </div>
         </nav>
         <!-- /MENU -->
         <!-- RIGHT SIDE -->
         <div class="rightside-nav-2">
            <h3>Book Now</h3>
            <ul class="right-side-contact">
               <li><label>Address:</label> 40 Park Ave, Brooklyn, New York 70250</li>
               <li><label>Phone:</label> 000-111-2222</li>
               <li><label>Email:</label> .......... </li>
            </ul>
            <!-- SOCIAL ICONS -->
            <ul class="search-social search-social-2">
               <li><a class="social-facebook" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
               <li><a class="social-twitter" href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
               <li><a class="social-tripadvisor" href="#" target="_blank"><i class="fab fa-tripadvisor"></i></a></li>
               <li><a class="social-pinterest" href="#" target="_blank"><i class="fab fa-pinterest"></i></a></li>
               <li><a class="social-instagram" href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
            </ul>
            <!-- /SOCIAL ICONS -->
         </div>
         <!-- /RIGHT SIDE -->
      </div>
      <!-- /MOBILE MENU -->
      <!-- HEADER -->
      <header id="header-1">
         <div class="headerWrap-1">
            <nav class="navbar-1">
               <!-- TOP LEFT PAGE TEXT  -->
               <div class="top-location">
                  <span class="info-txt">{{ $settings->store_address }} </span>
               </div>
               <!-- TOP RIGHT PAGE TEXT  -->
               <div class="book-now">
                  <span class="info-txt">Contact Now</span>
                  <span class="info-txt">{{ $settings->store_contact  }}</span>   
               </div>
               <!-- MOBILE BUTTON NAV  -->
               <div class="nav-button-holder nav-btn-mobile inactive">
                  <span class="menu-txt">MENU</span>
                  <button type="button" class="nav-button">
                  <span class="icon-bar"></span>
                  </button>
               </div>
               <div class="nav-content-1">
                  <!-- LOGO -->
                  <div class="logo-1"><a href="{{ url('items') }}/{{ $vendor->code }}"><img class="img-fluid" src="{{ asset('qr-webapp/images/logo-dina-white.png')}}" alt="" /></a></div>
                  <!-- MENU -->
                  <div class="nav-holder nav-holder-1 nav-holder-desktop">
                     <ul id="menu-menu-1" class="menu-nav menu-nav-1">
                        <li class="menu-item"><a href="{{ url('items') }}/{{ $vendor->code }}">Home</a></li>
                        <li class="menu-item"><a href="{{ url('items') }}/{{ $vendor->code }}">Menu</a></li>
                        <li class="menu-item"><a href="reservation.html">Reservation</a></li>
                        <li class="menu-item"><a href="{{ url('contact') }}/{{ $vendor->code }}">Contact</a></li>
                     </ul>
                  </div>
                  <!-- /MENU -->
               </div>
            </nav>
         </div>
         <!--headerWrap-->
      </header>
      <!-- /HEADER -->
      <!--Begin::Content-->
      @yield('content')
      <!--End::Content-->
      <!-- FOOTER -->
      <footer>
         <div class="container">
            <!-- ROW -->
            <div class="row alignc">
               <!-- FOOTER COLUMN 1 -->
               <div class="col-md-4">
                  <div class="footer-content">
                     <h5>ADDRESS:</h5>
                     <p>{{ $settings->store_name }} <br/>
                        {{ $settings->store_address }}
                     </p>
                  </div>
               </div>
               <!-- FOOTER COLUMN 2 -->
               <div class="col-md-4">
                  <div class="footer-content">
                     <h5>RESERVATION:</h5>
                     <p>{{ $settings->store_contact  }}<br/>
                        <a href="" class="__cf_email__">{{ $settings->store_email }}</a>
                     </p>
                  </div>
               </div>
               <!-- FOOTER COLUMN 3 -->
               <div class="col-md-4">
                  <div class="footer-content">
                     <h5>OPEN HOURS:</h5>
                     <p>Monday - Friday: 10 AM - 11 PM <br/>
                        Saturday - Sunday: 9 AM - 1 PM
                     </p>
                  </div>
               </div>
            </div>
            <!-- /ROW -->
            <!-- FOOTER SOCIAL -->
            <ul class="footer-social">
               <li><a class="social-facebook" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
               <li><a class="social-twitter" href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
               <li><a class="social-instagram" href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
            </ul>
            <!-- /FOOTER SOCIAL -->
            <!-- FOOTER COPYRIGHT -->
            <div class="copyright">
               Copyright &copy; <span id="year"></span>, Digital QR. Designed & Developed by <a href="https://digitalqr.in" target="_blank">digitalqr.in</a>
            </div>

            <script>
                document.getElementById("year").textContent = new Date().getFullYear();
            </script>

            <!-- /FOOTER COPYRIGHT -->
            <!-- FOOTER SCROLL UP -->
            <div class="scrollup">
               <a class="scrolltop" href="#">
               <i class="fas fa-chevron-up"></i>
               </a>
            </div>
            <!-- /FOOTER SCROLL UP -->
         </div>
         <!--container-->
      </footer>
      <!-- /FOOTER -->
      <!-- JS --> 
     
      <!-- Remove or comment out this line -->
      
      <script  src="{{ asset('qr-webapp/js/jquery-migrate.min.js')}}"></script>
      <script  src="{{ asset('qr-webapp/css/bootstrap/js/popper.min.js')}}"></script>
      <script  src="{{ asset('qr-webapp/css/bootstrap/js/bootstrap.min.js')}}"></script>
      <script  src="{{ asset('qr-webapp/js/jquery.easing.min.js')}}"></script>
      <script  src="{{ asset('qr-webapp/js/jquery.fitvids.js')}}"></script>
      <script  src="{{ asset('qr-webapp/js/jquery.magnific-popup.min.js')}}"></script>
      <script  src="{{ asset('qr-webapp/js/owl-carousel/owl.carousel.min.js')}}"></script>
      <!-- MAIN JS -->
      <script  src="{{ asset('qr-webapp/js/init.js')}}"></script>
   </body>
</html>