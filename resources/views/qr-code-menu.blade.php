@extends('default') 
@section('title', 'QR Code Menu - Digital QR')
@section('content')

<section class="herobannersect">
   <div class="container">
      <div class="herob-wrap">
         <h1>Enhance Your Business with Our QR Code Menu Solution</h1>
      </div>
   </div>
</section>

<section class="screens-sect digitalMenu">
   <div class="container">
      <div class="screen-wrap scrn-one">
         <div class="screen-left">
            <p>
               Upgrade your business with our innovative <strong>QR Code Menu</strong> system. Allow customers to access your menu instantly by scanning a QR code—no apps, no hassle. Provide a seamless, contactless, and modern experience that simplifies ordering and enhances customer satisfaction.
            </p>
            <p>
               The <strong>QR Code Menu</strong> is a game-changer for businesses looking to streamline operations and improve customer engagement. Whether you run a restaurant, café, bar, or food truck, our digital menu solution eliminates the need for printed menus and enables real-time updates at your fingertips.
            </p>
         </div>
         <div class="screen-right">
            <img src="{{ asset('qr-app/images/digital.png') }}"> <!-- You can update the image file if needed -->
         </div>
      </div>

      <div class="fullPara">
         <p>Our <strong>easy-to-use platform</strong> allows you to update your menu items, change prices, and mark items as available or unavailable in just a few clicks. Say goodbye to reprinting costs and outdated paper menus. Customers can view your latest offerings instantly by scanning a QR code using their smartphones.</p>

         <p>The <strong>QR Code Menu</strong> supports <strong>multiple categories</strong> such as food, beverages, daily specials, and desserts. You can showcase high-quality images, detailed descriptions, and ingredient information to help customers make informed choices. Since it works on all devices without requiring an app, it ensures a <strong>frictionless experience</strong> for both customers and business owners.</p>

         <p>Our cloud-based system provides <strong>real-time updates and centralized control</strong>, making it ideal for businesses with multiple locations. No more worrying about outdated menus—your customers will always see the most recent version. The platform is designed for <strong>speed, security, and reliability</strong>, ensuring smooth operation at all times.</p>

         <p>Additionally, the <strong>QR Code Menu</strong> helps businesses boost engagement and increase revenue. You can use it to highlight promotions, offer special discounts, and encourage upselling through visually appealing menu layouts. Integrated analytics allow you to track popular items and customer preferences, helping you refine your offerings based on real-time data.</p>

         <p>Our <strong>affordable subscription model</strong> ensures that businesses of all sizes can leverage this modern solution. For just <strong>₹30 per month</strong>, you get access to a full-featured QR Code Menu that enhances customer convenience and simplifies menu management.</p>

         <p><strong>Upgrade to a QR Code Menu today and take your business to the next level!</strong> Contact us now to get started and transform the way you serve your customers.</p>
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
				<img src="{{ asset('qr-app/images/join.svg') }}">
			</div>
		</div>
	</div>
</section>

@endsection
