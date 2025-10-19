@extends('default') 
@section('title', 'Digital Menu - Digital QR')
@section('content')
<section class="herobannersect">
   <div class="container">
      <div class="herob-wrap">
         <h1>Transform Your Business with Our Digital Menu Solutions</h1>
      </div>
   </div>
</section>
<section class="screens-sect digitalMenu">
   <div class="container">
      <div class="screen-wrap scrn-one">
         <div class="screen-left">
            <p>
               Elevate your customer experience with our innovative Digital Menu system. Easily manage your menu, update prices, and mark item availability in real-time. Say goodbye to paper menus and welcome a seamless, contactless ordering experience that enhances customer satisfaction. 
            </p>
            <p>In today’s digital world, businesses must adopt smart solutions to stay ahead. Our **Digital Menu** system is designed to simplify menu management and improve efficiency, making it easier than ever to provide an engaging and hassle-free experience for your customers. Whether you own a restaurant, café, bar, or cloud kitchen, our platform ensures that your menu is always updated and accessible through a simple QR code scan.
            </p>
         </div>
         <div class="screen-right">
            <img src="{{ asset('qr-app/images/digital.png')}}">
         </div>
      </div>
      <div class="fullPara">
         <p>With our <strong>user-friendly interface</strong>, businesses can instantly modify menu items, update prices, add new offerings, and mark items as available or unavailable. This means you no longer need to print new menus for every change, saving both time and printing costs. Our digital solution also reduces waiting times, as customers can browse the menu and place orders directly from their smartphones.</p>
         <p>One of the standout features of our <strong>Digital Menu system</strong> is its adaptability. It supports <strong>multiple categories</strong>, including food, beverages, desserts, and daily specials. It also allows the inclusion of high-quality images, descriptions, and ingredient details, making it easier for customers to make informed choices. The system is compatible with all devices and does not require app downloads, ensuring a seamless experience for both customers and business owners.</p>
         <p>Security and reliability are at the core of our platform. Our cloud-based system ensures that your menu data is always safe and accessible, with **automatic updates** and <strong>real-time sync</strong> across multiple locations. Whether you manage a single outlet or a chain of businesses, our Digital Menu solution provides centralized control, reducing operational hassles.</p>
         <p>In addition to convenience, our Digital Menu system enhances customer engagement. Businesses can use it to highlight promotions, offer discounts, and encourage upselling through visually appealing layouts. The integration of customer feedback options and analytics helps you understand preferences, track popular items, and refine your offerings based on real-time insights.</p>
         <p>Our <strong>affordable subscription model</strong> makes it easy for businesses of all sizes to get started. For just ₹99 per month, you can access all the essential features to streamline menu management and improve customer satisfaction. Whether you run a small café or a large restaurant chain, our Digital Menu solution is designed to fit your needs.</p>
         <p>Make the smart move today— <strong>upgrade to a Digital Menu and provide a seamless, modern, and interactive dining experience!</strong> Contact us to get started and take your business to the next level.</p>
      </div>
   </div>
</section>
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
@endsection