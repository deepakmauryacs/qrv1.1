@extends('default') 
@section('content')
@php $version = time(); @endphp
<section id="hero-2" class="bg--fixed hero-section">
   <div class="container text-center">
      <!-- HERO TEXT -->
      <div class="row justify-content-center">
         <div class="col-md-9">
            <div class="hero-2-txt wow animate__animated animate__fadeInUp">
               <!-- Title -->
               <h2>Transform Your Business with Digital QR – Smart & Hassle-Free Menus & Product Listings</h2>
               <!-- Text -->
               <p class="p-lg">Enhance your store's efficiency with Digital QR – a seamless, contactless digital system. Let customers explore  products, place orders with ease, 
                and elevate their shopping experience with just a scan.
               </p>
               <!-- Buttons -->  
               <div class="btns-group">
                  <a href="{{ url('vendor/onboarding') }}" class="btn btn-md r-06 btn--theme hover--theme">Start for free</a>
                  <a href="{{ url('contact-us') }}" class="btn btn-md r-06 btn--tra-black hover--theme">Contact Us</a>
               </div>
            </div>
         </div>
      </div>
      <!-- END HERO TEXT -->  
      <!-- HERO IMAGE -->
      <div class="row">
         <div class="col">
            <div class="hero-2-img video-preview wow animate__animated animate__fadeInUp">
               <!-- Play Icon --> 
               <!-- <a class="video-popup1" href="https://www.youtube.com/embed/SZEflIVnhH8">
                  <div class="video-btn video-btn-xl bg--pink">
                     <div class="video-block-wrapper"><span class="flaticon-play-button"></span></div>
                  </div>
                  </a> -->
               <!-- Preview Image --> 
               <img class="img-fluid" src="{{ asset('web-app/images/dashboard-02.png')}}?v={{ $version }}" alt="video-preview" style="border-radius:15px;"> 
            </div>
         </div>
      </div>
      <!-- END HERO IMAGE -->    
   </div>
   <!-- End container --> 
</section>
<section id="features-2" class="py-100 features-section division">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-9">
            <div class="section-title mb-80">
               <!-- Title -->
               <h2 class="h2-xl">The Complete Solution for Digital Menus</h2>
               <!-- Text -->    
               <p class="p-xl">Empower your restaurant with Digital QR – the simplest way to offer a seamless, 
                  interactive, and touch-free menu experience.
               </p>
            </div>
         </div>
      </div>
      <div class="fbox-wrapper">
         <div class="row row-cols-1 row-cols-md-2 rows-3">
            <!-- FEATURE BOX #1 -->
            <div class="col">
               <div class="fbox-2 fb-1 wow animate__animated animate__fadeInUp">
                  <div class="fbox-ico-wrap">
                     <div class="fbox-ico color--theme ico-55">
                        <div class="shape-ico color--theme">
                           <!-- Bootstrap Icon -->
                           <i class="bi bi-qr-code-scan" style="font-size: 35px;"></i>
                        </div>
                     </div>
                  </div>
                  <!-- Text -->
                  <div class="fbox-txt">
                     <h5>Instant QR Menus</h5>
                     <p>Generate unique QR codes for your restaurant and let customers access the menu instantly by scanning.</p>
                  </div>
               </div>
            </div>
            <!-- FEATURE BOX #2 -->
            <div class="col">
               <div class="fbox-2 fb-2 wow animate__animated animate__fadeInUp">
                  <div class="fbox-ico-wrap">
                     <div class="fbox-ico color--theme ico-55">
                        <div class="shape-ico color--theme">
                           <i class="bi bi-phone" style="font-size: 35px;"></i>
                        </div>
                     </div>
                  </div>
                  <!-- Text -->
                  <div class="fbox-txt">
                     <h5>Mobile-Friendly</h5>
                     <p>Your digital menu is fully responsive and optimized for mobile devices, ensuring a seamless experience.</p>
                  </div>
               </div>
            </div>
            <!-- FEATURE BOX #3 -->
            <div class="col">
               <div class="fbox-2 fb-3 wow animate__animated animate__fadeInUp">
                  <div class="fbox-ico-wrap">
                     <div class="fbox-ico color--theme ico-55">
                        <div class="shape-ico color--theme">
                           <i class="bi bi-pencil-square" style="font-size: 35px;"></i>
                        </div>
                     </div>
                  </div>
                  <!-- Text -->
                  <div class="fbox-txt">
                     <h5>Easy Menu Updates</h5>
                     <p>Update your menu in real-time without the hassle of reprinting paper menus.</p>
                  </div>
               </div>
            </div>
            <!-- FEATURE BOX #4 -->
            <div class="col">
               <div class="fbox-2 fb-4 wow animate__animated animate__fadeInUp">
                  <div class="fbox-ico-wrap">
                     <div class="fbox-ico color--theme ico-55">
                        <div class="shape-ico color--theme">
                           <i class="bi bi-cash" style="font-size: 35px;"></i>
                        </div>
                     </div>
                  </div>
                  <!-- Text -->
                  <div class="fbox-txt">
                     <h5>Contactless Ordering</h5>
                     <p>Enhance customer safety by providing a fully touchless ordering system.</p>
                  </div>
               </div>
            </div>
            <!-- FEATURE BOX #5 -->
            <div class="col">
               <div class="fbox-2 fb-5 wow animate__animated animate__fadeInUp">
                  <div class="fbox-ico-wrap">
                     <div class="fbox-ico color--theme ico-55">
                        <div class="shape-ico color--theme">
                           <i class="bi bi-bar-chart" style="font-size: 35px;"></i>
                        </div>
                     </div>
                  </div>
                  <!-- Text -->
                  <div class="fbox-txt">
                     <h5>Sales Insights</h5>
                     <p>Track customer preferences and menu performance with analytics.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<hr class="divider">
<section class="pt-100 ct-01 content-section division mb-80">
   <div class="container">
      <div class="row d-flex align-items-center">
         <!-- TEXT BLOCK -->  
         <div class="col-md-6 order-last order-md-2">
            <div class="txt-block left-column wow animate__animated animate__fadeInRight">
               <!-- Section ID -->    
               <span class="section-id">Revolutionizing Restaurant Experience</span>
               <!-- Title -->    
               <h2>Enhance Your Business with a Smart Digital Menu</h2>
               <!-- Text -->    
               <p>Say goodbye to outdated paper menus and welcome a seamless, interactive dining experience. Digital QR 
                  helps your restaurant stay ahead with quick updates, effortless management, and a contactless menu solution.
               </p>
               <!-- CBOX WRAPPER -->    
               <div class="cbox-5-wrapper">
                  <div class="row">
                     <!-- CONTENT BOX #1 -->
                     <div class="col-md-6">
                        <div class="cbox-5 cb-1">
                           <!-- Icon & Title -->
                           <div class="box-title ico-30">
                              <i class="bi bi-lightbulb color--theme"></i>
                              <h6 class="h6-lg">Smart & Interactive</h6>
                           </div>
                           <!-- Text -->
                           <p class="p-sm">Provide customers with an easy-to-use, dynamic, and visually appealing menu at their fingertips.</p>
                        </div>
                     </div>
                     <!-- END CONTENT BOX #1 -->
                     <!-- CONTENT BOX #2 -->
                     <div class="col-md-6">
                        <div class="cbox-5 cb-2">
                           <!-- Icon & Title -->
                           <div class="box-title ico-30">
                              <i class="bi bi-gear-wide color--theme"></i>
                              <h6 class="h6-lg">Flexible & Customizable</h6>
                           </div>
                           <!-- Text -->
                           <p class="p-sm">Easily update your menu items, pricing, and availability in real-time without any hassle.</p>
                        </div>
                     </div>
                     <!-- END CONTENT BOX #2 -->
                  </div>
               </div>
               <!-- END CBOX WRAPPER -->    
            </div>
         </div>
         <!-- END TEXT BLOCK --> 
         <!-- IMAGE BLOCK -->
         <div class="col-md-6 order-first order-md-2">
            <div class="img-block right-column wow animate__animated animate__fadeInLeft">
               <img class="img-fluid lt-img" src="{{ asset('web-app/images/smart-digital-menu-qr.png')}}?v={{ $version }}" alt="content-image" style="border-radius: 15px;">
               <img class="img-fluid dt-img" src="{{ asset('web-app/images/smart-digital-menu-qr.png')}}?v={{ $version }}" alt="content-image" style="border-radius: 15px;">
            </div>
         </div>
      </div>
      <!-- End row -->
   </div>
   <!-- End container -->
</section>
<hr class="divider">
<section id="features-4" class="shape--bg shape--whitesmoke pt-100 features-section division mb-80">
   <div class="container">
      <div class="row d-flex align-items-center">
         <!-- FEATURES-4 WRAPPER -->
         <div class="col-md-7 order-last order-md-2">
            <div class="fbox-4-wrapper">
               <div class="row">
                  <div class="col-md-6">
                     <!-- FEATURE BOX #1 -->
                     <div id="fb-4-1" class="fbox-4 block--shadow r-12 wow animate__animated animate__fadeInRight">
                        <!-- Icon -->
                        <div class="fbox-ico ico-50">
                           <div class="shape-ico color--theme">
                              <i class="bi bi-qr-code-scan" style="font-size: 35px;"></i>
                           </div>
                        </div>
                        <!-- End Icon -->
                        <!-- Title -->
                        <h6 class="h6-lg">QR Code Menu</h6>
                        <!-- Text -->
                        <p>Provide customers with a simple scan-to-view digital menu, ensuring a seamless experience.</p>
                     </div>
                     <!-- FEATURE BOX #2 -->
                     <div id="fb-4-2" class="fbox-4 block--shadow r-12 wow animate__animated animate__fadeInRight">
                        <!-- Icon -->
                        <div class="fbox-ico ico-50">
                           <div class="shape-ico color--theme">
                              <i class="bi bi-bar-chart" style="font-size: 35px;"></i>
                           </div>
                        </div>
                        <!-- End Icon -->
                        <!-- Title -->
                        <h6 class="h6-lg">Sales Insights</h6>
                        <!-- Text -->
                        <p>Get valuable insights into your customers’ preferences and menu performance.</p>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <!-- FEATURE BOX #3 -->
                     <div id="fb-4-3" class="fbox-4 block--shadow r-12 wow animate__animated animate__fadeInRight">
                        <!-- Icon -->
                        <div class="fbox-ico ico-50">
                           <div class="shape-ico color--theme">
                              <i class="bi bi-pencil-square" style="font-size: 35px;"></i>
                           </div>
                        </div>
                        <!-- End Icon -->
                        <!-- Title -->
                        <h6 class="h6-lg">Instant Menu Updates</h6>
                        <!-- Text -->
                        <p>Modify your menu items, pricing, and availability instantly without reprinting costs.</p>
                     </div>
                     <!-- FEATURE BOX #4 -->
                     <div id="fb-4-4" class="fbox-4 block--shadow r-12 wow animate__animated animate__fadeInRight">
                        <!-- Icon -->
                        <div class="fbox-ico ico-50">
                           <div class="shape-ico color--theme">
                              <i class="bi bi-credit-card" style="font-size: 35px;"></i>
                           </div>
                        </div>
                        <!-- End Icon -->
                        <!-- Title -->
                        <h6 class="h6-lg">Contactless Payments</h6>
                        <!-- Text -->
                        <p>Enable customers to place orders and pay digitally for a faster, safer experience.</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End row -->
         </div>
         <!-- END FEATURES-4 WRAPPER -->
         <!-- TEXT BLOCK -->    
         <div class="col-md-5 order-first order-md-2">
            <div class="txt-block left-column wow animate__animated animate__fadeInLeft">
               <!-- Section ID -->    
               <span class="section-id">Digital Solutions</span>
               <!-- Title -->    
               <h2>Upgrade Your Restaurant with a Smart Digital Menu</h2>
               <!-- Text -->    
               <p>Transform your dining experience with a quick, efficient, and customer-friendly QR menu system.</p>
               <!-- Text -->    
               <p class="mb-0">Say goodbye to paper menus and welcome real-time updates, seamless customer interactions, 
                  and data-driven insights to grow your business.
               </p>
            </div>
         </div>
         <!-- END TEXT BLOCK -->    
      </div>
      <!-- End row -->
   </div>
   <!-- End container -->
</section>
<div id="statistic-1" class="py-100 statistic-section division mb-80">
   <div class="container">
      <!-- STATISTIC-1 WRAPPER -->
      <div class="statistic-1-wrapper">
         <div class="row justify-content-md-center row-cols-1 row-cols-md-3">
            <!-- STATISTIC BLOCK #1 -->
            <div class="col">
               <div id="sb-1-1" class="animate__animated animate__fadeInUp">
                  <div class="statistic-block">
                     <!-- Digit -->
                     <div class="statistic-block-digit text-center">
                        <h2 class="h2-xl statistic-number">
                           <span class="count-element">10</span><small>k+</small>
                        </h2>
                     </div>
                     <!-- Text -->
                     <div class="statistic-block-txt color--grey">
                        <p class="p-md">Restaurants Using Digital QR</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- END STATISTIC BLOCK #1 -->
            <!-- STATISTIC BLOCK #2 -->
            <div class="col">
               <div id="sb-1-2" class="animate__animated animate__fadeInUp">
                  <div class="statistic-block">
                     <!-- Digit -->
                     <div class="statistic-block-digit text-center">
                        <h2 class="h2-xl statistic-number">
                           <span class="count-element">95</span><small>%</small>
                        </h2>
                     </div>
                     <!-- Text -->
                     <div class="statistic-block-txt color--grey">
                        <p class="p-md">Customer Satisfaction Rate</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- END STATISTIC BLOCK #2 -->
            <!-- STATISTIC BLOCK #3 -->
            <div class="col">
               <div id="sb-1-3" class="animate__animated animate__fadeInUp">
                  <div class="statistic-block">
                     <!-- Digit -->
                     <div class="statistic-block-digit text-center">
                        <h2 class="h2-xl statistic-number">
                           <span class="count-element">4</span>.<span class="count-element">9</span>
                        </h2>
                     </div>
                     <!-- Text -->
                     <div class="statistic-block-txt color--grey">
                        <p class="p-md">Average User Rating</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- END STATISTIC BLOCK #3 -->
         </div>
         <!-- End row -->
      </div>
      <!-- END STATISTIC-1 WRAPPER -->
   </div>
   <!-- End container -->        
</div>
<hr class="divider">
<section class="pt-100 ct-03 content-section division">
   <div class="container">
      <div class="row d-flex align-items-center">
         <div class="col-md-6 col-lg-7">
            <div class="img-block left-column wow animate__animated animate__fadeInRight">
               <img class="img-fluid dt-img" src="{{ asset('web-app/images/smart-digital-menus.png')}}?v={{ $version }}" alt="content-image" style="border-radius: 15px;">
            </div>
         </div>
         <div class="col-md-6 col-lg-5">
            <div class="txt-block right-column wow animate__animated animate__fadeInLeft">
               <span class="section-id">Enhance Your Restaurant Experience</span>
               <h2>Smart Digital Menus for Modern Dining</h2>
               <ul class="simple-list">
                  <li class="list-item">
                     <p>Say goodbye to paper menus—provide customers with a seamless, contactless digital menu that enhances convenience and efficiency.</p>
                  </li>
                  <li class="list-item">
                     <p class="mb-0">Easily update your menu, showcase offers, and improve customer satisfaction with real-time changes at your fingertips.</p>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>
<section id="reviews-2" class="pt-100 reviews-section division">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-10 col-lg-9">
            <div class="section-title mb-70">
               <!-- Title -->    
               <h2 class="h2-xl">What Restaurants Say About Digital QR</h2>
               <!-- Text -->    
               <p class="p-xl">See how Digital QR has transformed restaurant experiences for our customers.</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="owl-carousel owl-theme reviews-carousel">
               <div class="review-2">
                  <!-- Rating -->
                  <div class="review-rating ico-15 color--yellow">
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="review-2-txt">
                     <h5>Seamless and Easy to Use</h5>
                     <p>&quot;Switching to Digital QR was the best decision for our restaurant. Customers love the quick, touchless menu access!&quot;</p>
                  </div>
                  <div class="review-author">
                     <h6>Raj Malhotra</h6>
                     <p class="p-sm">Owner, Spice Hub</p>
                  </div>
               </div>
               <div class="review-2">
                  <!-- Rating -->
                  <div class="review-rating ico-15 color--yellow">
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-half"></i>
                  </div>
                  <div class="review-2-txt">
                     <h5>Boosted Sales & Customer Engagement</h5>
                     <p>&quot;With Digital QR, we can update our menu instantly, and sales have increased as customers find it easier to explore our dishes!&quot;</p>
                  </div>
                  <div class="review-author">
                     <h6>Anita Verma</h6>
                     <p class="p-sm">Manager, The Food Court</p>
                  </div>
               </div>
               <div class="review-2">
                  <div class="review-rating ico-15 color--yellow">
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="review-2-txt">
                     <h5>Hassle-Free Menu Management</h5>
                     <p>&quot;No more reprinting menus! We update specials daily with ease. The platform is user-friendly and highly efficient.&quot;</p>
                  </div>
                  <!-- Author -->
                  <div class="review-author">
                     <h6>Vikram Sharma</h6>
                     <p class="p-sm">Chef & Owner, Tandoori Nights</p>
                  </div>
               </div>
               <div class="review-2">
                  <div class="review-rating ico-15 color--yellow">
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-half"></i>
                  </div>
                  <div class="review-2-txt">
                     <h5>Perfect for Small & Large Restaurants</h5>
                     <p>&quot;Digital QR works flawlessly whether you have one location or multiple outlets. Highly recommended!&quot;</p>
                  </div>
                  <div class="review-author">
                     <h6>Sonia Gupta</h6>
                     <p class="p-sm">Franchise Owner, Urban Bites</p>
                  </div>
               </div>
               <div class="review-2">
                  <!-- Rating -->
                  <div class="review-rating ico-15 color--yellow">
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                     <i class="bi bi-star-fill"></i>
                  </div>
                  <div class="review-2-txt">
                     <h5>Excellent Support & Features</h5>
                     <p>&quot;The support team is fantastic! They helped us integrate Digital QR into our existing system seamlessly.&quot;</p>
                  </div>
                  <div class="review-author">
                     <h6>Arjun Mehta</h6>
                     <p class="p-sm">Co-Founder, Flavors & Spices</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection