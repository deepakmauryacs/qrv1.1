@extends('default') 
@section('title', 'Admin Dashboard - Digital QR')
@section('content')
<section class="screens-sect digitalMenu admin-dashboardCont">
   <div class="container">
      <div class="screen-wrap scrn-one">
         <div class="screen-left">
            <h1>Manage Your QR Code Menu System</h1>
            <p>Welcome to the <strong>Admin Dashboard</strong> of our QR Code Menu system! Here, you can efficiently manage all aspects of your digital menu, track QR code scans, monitor customer interactions, and streamline menu updates—all from a single, user-friendly interface.</p>
            <p>Our <strong>dashboard provides real-time insights</strong> into menu performance, including the total number of menu items, daily QR scans, overall QR activity, and customer feedback. With an intuitive interface, you can easily add, edit, or remove menu items, ensuring that your customers always see the latest updates without the need for physical reprints.</p>
            <a class="msgReadMore" href="#">Read More </a>
         </div>
         <div class="screen-right">
            <img src="{{ asset('qr-app/images/admin-dashboard.png')}}">
         </div>
      </div>
   </div>
</section>
<div class="keyFeatureContainer">
   <div class="container  ">
      <h2>Key Features of the Admin Dashboard</h2>
      <div class="keyFeature">
         <div class="keycontent">
            <figure>
               <img src="{{ asset('qr-app/images/clock-three.svg')}}">
            </figure>
            <h3>Real-time menu management </h3>
            <h4>Add, edit, or remove menu items instantly.</h4>
         </div>
         <div class="keycontent">
            <figure>
               <img src="{{ asset('qr-app/images/qr-scan.svg')}}">
            </figure>
            <h3>QR Code scan analytics </h3>
            <h4>Monitor customer engagement and track trends.</h4>
         </div>
         <div class="keycontent">
            <figure>
               <img src="{{ asset('qr-app/images/refer.svg')}}">
            </figure>
            <h3>QR Code generation & sharing</h3>
            <h4>Easily create and distribute QR codes.</h4>
         </div>
         <div class="keycontent">
            <figure>
               <img src="{{ asset('qr-app/images/user-experience.svg')}}">
            </figure>
            <h3>Customer feedback tracking </h3>
            <h4>View and analyze reviews to improve service.</h4>
         </div>
         <div class="keycontent">
            <figure>
               <img src="{{ asset('qr-app/images/module.svg')}}">
            </figure>
            <h3>Menu cloning & setup</h3>
            <h4>Duplicate existing menus for quick setup.</h4>
         </div>
      </div>
   </div>
</div>
<section class="joindigital-sect">
   <div class="container">
      <div class="join-grid">
         <div class="join-left">
            <h2>Join 10K+ Restaurants Already Using Digital QR</h2>
            <div class="btn-action-wrap">
               <a href="{{ url('vendor/onboarding') }}" class="action-filled">Start for free</a>
               <a href="{{ url('contact-us') }}" class="action-outline">Contact Us</a>
            </div>
         </div>
         <div class="join-right">
            <img src="{{ asset('qr-app/images/join.svg')}}">
         </div>
      </div>
   </div>
</section>
<div class="msg-slider">
   <div class="msg-slider-left">
      <div class="screen-left">
         <h1>Manage Your QR Code Menu System</h1>
         <p>Welcome to the <strong>Admin Dashboard</strong> of our QR Code Menu system! Here, you can efficiently manage all aspects of your digital menu, track QR code scans, monitor customer interactions, and streamline menu updates—all from a single, user-friendly interface.</p>
         <p>Our <strong>dashboard provides real-time insights</strong> into menu performance, including the total number of menu items, daily QR scans, overall QR activity, and customer feedback. With an intuitive interface, you can easily add, edit, or remove menu items, ensuring that your customers always see the latest updates without the need for physical reprints.</p>
         <p>
            The <strong>QR Code section</strong> allows you to generate, download, and share QR codes, making it simple for businesses to display them at tables, counters, or promotional materials. Customers can scan these codes using their smartphones to instantly access the menu, view prices, and place orders without touching a physical menu.				
         </p>
         <p>
            Additionally, our **data analytics feature** helps you track customer engagement and understand menu popularity. The dashboard includes interactive charts and reports that display scan trends over different time periods, giving you valuable insights into customer behavior.			
         </p>
         <p>
            Our <strong>cloud-based admin panel</strong> ensures that all menu updates sync automatically across all customer touchpoints, eliminating the hassle of manual updates. Whether you manage a single business or multiple locations, our QR Code Menu dashboard gives you complete control over your digital dining experience.			
         </p>
         <p>
            Take full control of your menu today!** Use the Admin Dashboard to optimize your digital menu system and enhance customer engagement effortlessly.	
         </p>
      </div>
   </div>
   <a class="sliderCross" href="javascript:void(0)">
      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
         <g>
            <g data-name="02 User">
               <path d="M25 512a25 25 0 0 1-17.68-42.68l462-462a25 25 0 0 1 35.36 35.36l-462 462A24.93 24.93 0 0 1 25 512z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
               <path d="M487 512a24.93 24.93 0 0 1-17.68-7.32l-462-462A25 25 0 0 1 42.68 7.32l462 462A25 25 0 0 1 487 512z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
            </g>
         </g>
      </svg>
   </a>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		const msgReadMore = document.querySelector(".msgReadMore");
		const closeButton = document.querySelector(".sliderCross");
		const body = document.body;

		if (msgReadMore) {
		  msgReadMore.addEventListener("click", function (event) {
			event.preventDefault();
			body.classList.add("modal-active");
		  });
		}

		if (closeButton) {
		  closeButton.addEventListener("click", function () {
			body.classList.remove("modal-active");
		  });
		}
	});
</script>
@endsection