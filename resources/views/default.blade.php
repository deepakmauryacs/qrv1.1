<!DOCTYPE html>
<html lang="en">
<head>
	@php $version = time(); @endphp
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Primary Meta Tags -->
    <meta name="author" content="AETHERGRID INNOVATECH PRIVATE LIMITED">
    <meta name="description" content="Digital QR offers a smart & contactless QR solution for restaurants, bakeries, stationery stores, accessories, grocery stores, supermarkets, flower shops, and gift stores. Upgrade your business with a QR menu or product catalog at just ₹99/month.">
    <meta name="keywords" content="Digital QR, QR menu, QR product listing, bakery QR menu, contactless QR, grocery QR menu, supermarket digital menu, flower shop QR, stationery QR, accessories store QR, online product catalog, QR code ordering, digital menu India">
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
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.carousel.min.css'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.theme.default.min.css'>	<link rel="stylesheet" href="{{ asset('qr-app/css/demo.css')}}">	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   	
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script src="{{ asset('qr-app/js/hc-offcanvas-nav.js')}}"></script>
	<link href="{{ asset('qr-app/css/custom.css')}}" rel="stylesheet"> 
	<link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
	<style>
	 body {
	    font-family: 'DM Sans';
	 }
	</style>
</head>
<body class="homepage theme-default">
 

	<section class="mobnavigation mshow">
		<div class="container">
			<div class="mobnavwrap">
				<div class="mobheaderhumb">
					 <a href="https://www.digitalqr.in"><img src="{{ asset('qr-app/images/logo.png')}}"></a>
					<a class="toggle hc-nav-trigger hc-nav-1" href="#" role="button" aria-label="Open Menu" aria-controls="hc-nav-1" aria-expanded="false">
						<span>
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#000000" fill-rule="evenodd" d="M3 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h10a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm0 6a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1z" clip-rule="evenodd" opacity="1" data-original="#000000"></path></g></svg>
						</span>
					</a> 
				</div>
				<header>
					<nav id="main-nav" class="hc-nav-original hc-nav-1">
						<ul class="first-nav">
							<li class="">
								<a href="#" rel="noreferrer" target="_blank">Products</a>						
								<ul>
									<li>
										<a class="" href="{{ url('digital-menu') }}">						
											<span>Digital Menu</span>
										</a>
									</li>
									<li>
										<a class="" href="{{ url('qr-code-menu') }}">						
											<span>Qr Code Menu</span>
										</a>
									</li>
									<li>
										<a class="" href="{{ url('admin-dashboard') }}">						
											<span>Admin Dashboard</span>
										</a>
									</li>
								</ul>            						
							</li>
							<li class="">
								<a href="#" rel="noreferrer" target="_blank">Industry</a>						
								<ul>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Food & Restaurant</span>
										</a>
									</li>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Bakery</span>
										</a>
									</li>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Stationery</span>
										</a>
									</li>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Accessories</span>
										</a>
									</li>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Grocery & Supermarkets</span>
										</a>
									</li>
									<li>
										<a class="" href="javascript:void(0)">						
											<span>Flowers & Gifts</span>
										</a>
									</li>
								</ul>            						
							</li>
							<li class="">
								<a href="{{ url('pricing') }}">Pricing</a>           						
							</li>
							<li class="">
								<a href="javascript:void(0)">Demo</a>           						
							</li>
							<li class="">
								<a href="{{ url('contact-us') }}">Contact Us</a>           						
							</li>
							<li class="">
								<a href="{{ url('vendor/login') }}">Login</a>           						
							</li>
							<li class="startFree">
								<a href="{{ url('vendor/onboarding') }}" class="action-filled">Start for free</a>        						
							</li>							
						</ul>
					</nav>


				</header>
			
			</div>
		</div>
	</section>  
	<nav class="dshow">
		<div class="container">
			<div class="nav-wrap">
				<a href="https://www.digitalqr.in" class="logo-black"><img src="{{ asset('qr-app/images/logo.png')}}"></a>
				<ul>
					<li class="ddmenu">
						<a  href="#">
							Products
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M64 88a3.988 3.988 0 0 1-2.828-1.172l-40-40c-1.563-1.563-1.563-4.094 0-5.656s4.094-1.563 5.656 0L64 78.344l37.172-37.172c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656l-40 40A3.988 3.988 0 0 1 64 88z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>						
						</a>
						<ul class="sub-menu">
							<li><a href="{{ url('digital-menu') }}">Digital Menu</a></li>
							<li><a href="{{ url('qr-code-menu') }}">Qr Code Menu</a></li>
							<li><a href="{{ url('admin-dashboard') }}">Admin Dashboard</a></li>
						</ul>					
					</li>
					<li class="ddmenu">
						<a class="ddmenu" href="#">
							Industry
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M64 88a3.988 3.988 0 0 1-2.828-1.172l-40-40c-1.563-1.563-1.563-4.094 0-5.656s4.094-1.563 5.656 0L64 78.344l37.172-37.172c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656l-40 40A3.988 3.988 0 0 1 64 88z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>							
						</a>
						<ul class="sub-menu">
							<li><a href="javascript:void(0)">Food & Restaurant</a></li>
							<li><a href="javascript:void(0)">Bakery</a></li>
							<li><a href="javascript:void(0)">Stationery</a></li>
							<li><a href="javascript:void(0)">Accessories</a></li>
							<li><a href="javascript:void(0)">Grocery & Supermarkets</a></li>
							<li><a href="javascript:void(0)">Flowers & Gifts</a></li>
						</ul>							
					</li>
					<li><a  href="{{ url('pricing') }}">Pricing</a></li>
					<li class="ddmenu"><a  href="javascript:void(0)">Demo</a></li>
					<li class="ddmenu"><a href="{{ url('contact-us') }}">Contact Us</a></li>
					<li class="ddmenu"><a href="{{ url('vendor/login') }}">Login</a></li>
					<li class="startfree"><a href="{{ url('vendor/onboarding') }}" class="action-filled">Start for free</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!--Begin::Content-->
    @yield('content')
	<footer>
		<div class="container">
			<div class="footer-grid">
				<div class="compinfo">
					<img src="{{ asset('qr-app/images/logo.png')}}">
					<p>
						We offer a one-stop solution for businesses, specializing in Audit, Taxation, Valuation, 
					</p>
					<ul>
						<li>
							<a href="#">
								<svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7.38311 21.9889V11.9979H10.7367L11.2388 8.1042H7.38311V5.6182C7.38311 4.49091 7.69619 3.7226 9.31287 3.7226L11.3747 3.72165V0.239197C11.018 0.191918 9.79412 0.0859375 8.37026 0.0859375C5.39751 0.0859375 3.3623 1.90041 3.3623 5.23277V8.1043H0V11.998H3.36219V21.9891L7.38311 21.9889Z" fill="#D8D8D8"/>
								</svg>
							</a>
						</li>
						<li>
							<a href="#">
								<svg width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.9477 0.00488346V0H20.2174L20.6814 0.0927858C20.9906 0.153023 21.2714 0.231964 21.5238 0.329634C21.7761 0.427303 22.0203 0.541259 22.2563 0.671476C22.4923 0.801694 22.7064 0.934377 22.8985 1.06948C23.0889 1.20297 23.2598 1.34459 23.4112 1.49434C23.561 1.64573 23.7946 1.68479 24.112 1.61154C24.4294 1.53829 24.7713 1.43654 25.1375 1.30633C25.5038 1.17611 25.866 1.0296 26.2241 0.866815C26.5822 0.704024 26.8004 0.600666 26.8785 0.556715C26.955 0.511152 26.9957 0.486735 27.0006 0.483463L27.0054 0.476138L27.0299 0.463929L27.0543 0.45172L27.0787 0.439512L27.1031 0.427303L27.108 0.419978L27.1153 0.415094L27.1227 0.410211L27.1275 0.402886L27.1519 0.39556L27.1764 0.390677L27.1715 0.427303L27.1641 0.463929L27.1519 0.500555L27.1397 0.537181L27.1275 0.561598L27.1153 0.586016L27.1031 0.622642C27.095 0.647059 27.0868 0.679607 27.0787 0.720311C27.0706 0.761014 26.9932 0.92378 26.8467 1.20866C26.7002 1.49353 26.5171 1.78246 26.2973 2.07547C26.0776 2.36848 25.8806 2.58985 25.7065 2.73962C25.5307 2.89101 25.4143 2.99681 25.3573 3.05705C25.3003 3.1189 25.2311 3.17586 25.1497 3.22797L25.0276 3.30855L25.0032 3.32075L24.9788 3.33296L24.9739 3.34029L24.9666 3.34517L24.9593 3.35006L24.9544 3.35738L24.93 3.36959L24.9055 3.3818L24.9007 3.38912L24.8933 3.39401L24.886 3.39889L24.8811 3.40622L24.8763 3.41354L24.8689 3.41842L24.8616 3.42331L24.8567 3.43063H24.9788L25.6625 3.28413C26.1183 3.18646 26.5537 3.06845 26.9688 2.93008L27.6281 2.71032L27.7013 2.6859L27.738 2.6737L27.7624 2.66149L27.7868 2.64928L27.8112 2.63707L27.8356 2.62486L27.8845 2.61754L27.9333 2.61265V2.66149L27.9211 2.66637L27.9089 2.6737L27.904 2.68102L27.8967 2.6859L27.8893 2.69079L27.8845 2.69811L27.8796 2.70544L27.8722 2.71032L27.8649 2.71521L27.86 2.72253L27.8552 2.72986L27.8478 2.73474L27.8356 2.75916L27.8234 2.78357L27.8161 2.78846C27.8128 2.79334 27.7095 2.93169 27.506 3.20355C27.3025 3.47703 27.1926 3.61537 27.1764 3.61865C27.1601 3.62353 27.1373 3.64795 27.108 3.6919C27.0803 3.73746 26.9078 3.91898 26.5903 4.2364C26.2729 4.55383 25.962 4.83624 25.6576 5.08368C25.3516 5.33274 25.1969 5.63876 25.1937 6.00178C25.1888 6.36315 25.1701 6.77175 25.1375 7.22753C25.105 7.68332 25.0439 8.17572 24.9544 8.70477C24.8649 9.23382 24.7265 9.83205 24.5393 10.4994C24.3521 11.1668 24.1242 11.818 23.8556 12.4528C23.587 13.0877 23.3062 13.6574 23.0132 14.162C22.7202 14.6667 22.4516 15.094 22.2074 15.444C21.9633 15.7939 21.715 16.1236 21.4627 16.4329C21.2104 16.7421 20.8914 17.0905 20.5056 17.4779C20.1181 17.8637 19.9065 18.0753 19.8707 18.1128C19.8333 18.1486 19.6738 18.2821 19.3921 18.5132C19.1121 18.746 18.811 18.9787 18.4887 19.2115C18.168 19.4427 17.8734 19.6356 17.6048 19.7902C17.3362 19.9449 17.0123 20.1215 16.633 20.3201C16.2553 20.5203 15.8467 20.7059 15.4072 20.8768C14.9677 21.0477 14.5038 21.2064 14.0154 21.3529C13.5271 21.4994 13.055 21.6134 12.5992 21.6948C12.1434 21.7762 11.6266 21.8454 11.0487 21.9023L10.1819 21.9878V22H8.59478V21.9878L8.38723 21.9756C8.24889 21.9675 8.13493 21.9593 8.04539 21.9512C7.95588 21.943 7.61809 21.8983 7.03207 21.8169C6.44606 21.7355 5.98621 21.6541 5.65249 21.5727C5.31881 21.4913 4.82231 21.3367 4.16304 21.1088C3.50377 20.8809 2.93973 20.6505 2.47092 20.4178C2.00374 20.1866 1.71073 20.0401 1.5919 19.9782C1.47469 19.918 1.34284 19.8431 1.19633 19.7536L0.976579 19.6193L0.97172 19.612L0.96437 19.6071L0.957045 19.6022L0.952161 19.5949L0.927744 19.5827L0.903327 19.5705L0.898468 19.5632L0.891118 19.5583L0.883793 19.5534L0.87891 19.5461L0.87405 19.5387L0.866701 19.5339H0.854492V19.485L0.87891 19.4899L0.903327 19.4972L1.0132 19.5094C1.08646 19.5176 1.28587 19.5298 1.61143 19.5461C1.93701 19.5623 2.28291 19.5623 2.64916 19.5461C3.01542 19.5298 3.38984 19.4931 3.77236 19.4362C4.15491 19.3792 4.60663 19.2815 5.12752 19.1432C5.64844 19.0048 6.12702 18.8404 6.56328 18.6499C6.99791 18.4579 7.30718 18.3146 7.49114 18.2202C7.67344 18.1274 7.9518 17.9549 8.32619 17.7026L8.88779 17.3241L8.89267 17.3168L8.9 17.3119L8.90735 17.307L8.91221 17.2997L8.91709 17.2923L8.92441 17.2875L8.93176 17.2826L8.93662 17.2753L8.96104 17.2679L8.98546 17.263L8.99034 17.2386L8.99767 17.2142L9.00502 17.2093L9.00988 17.202L8.81454 17.1898C8.68432 17.1817 8.55815 17.1735 8.43607 17.1654C8.31398 17.1572 8.12272 17.1206 7.86226 17.0555C7.60183 16.9904 7.32103 16.8927 7.01986 16.7625C6.71873 16.6323 6.42572 16.4776 6.14084 16.2986C5.85599 16.1195 5.65005 15.9705 5.52308 15.8517C5.39775 15.7345 5.23496 15.5685 5.03474 15.3536C4.83615 15.1371 4.66359 14.9149 4.51709 14.687C4.37059 14.4591 4.2306 14.1962 4.09714 13.8983L3.89445 13.4539L3.88224 13.4173L3.87003 13.3807L3.86271 13.3563L3.85782 13.3319L3.89445 13.3367L3.93107 13.3441L4.19966 13.3807C4.37874 13.4051 4.65954 13.4132 5.04206 13.4051C5.42461 13.397 5.68912 13.3807 5.83562 13.3563C5.98213 13.3319 6.07167 13.3156 6.10421 13.3074L6.15305 13.2952L6.21409 13.283L6.27514 13.2708L6.28002 13.2635L6.28734 13.2586L6.29469 13.2537L6.29955 13.2464L6.25072 13.2342L6.20188 13.222L6.15305 13.2098L6.10421 13.1976L6.05538 13.1854C6.02283 13.1772 5.96587 13.1609 5.88446 13.1365C5.80308 13.1121 5.58332 13.0226 5.22519 12.8679C4.86709 12.7133 4.58221 12.5627 4.37059 12.4162C4.15844 12.2693 3.95615 12.1086 3.76504 11.9352C3.57458 11.7594 3.36542 11.5331 3.13751 11.2564C2.90962 10.9797 2.70615 10.6582 2.52708 10.2919C2.34803 9.92564 2.21373 9.57567 2.12419 9.24195C2.03501 8.9102 1.97618 8.57104 1.94841 8.22863L1.90444 7.71587L1.92885 7.72076L1.95327 7.72808L1.97769 7.74029L2.00211 7.7525L2.02652 7.76471L2.05094 7.77691L2.42941 7.94784C2.68174 8.06179 2.99509 8.15946 3.36948 8.24084C3.74389 8.32223 3.9677 8.36701 4.04095 8.37514L4.15083 8.38735H4.37059L4.36573 8.38002L4.35838 8.37514L4.35105 8.37026L4.34617 8.36293L4.34131 8.35561L4.33396 8.35072L4.32663 8.34584L4.32175 8.33851L4.29733 8.3263L4.27292 8.3141L4.26806 8.30677L4.26071 8.30189L4.25338 8.297L4.2485 8.28968L4.22408 8.27747L4.19966 8.26526L4.19481 8.25794C4.18992 8.25466 4.11992 8.20258 3.98479 8.10166C3.8513 7.99911 3.71132 7.86645 3.56481 7.70366C3.41831 7.54087 3.27181 7.36995 3.1253 7.1909C2.97853 7.01144 2.8478 6.81943 2.73463 6.61709C2.62069 6.41362 2.50022 6.15477 2.37325 5.84062C2.24792 5.52808 2.15269 5.2131 2.08757 4.89567C2.02247 4.57825 1.98584 4.2649 1.97769 3.95561C1.96956 3.64631 1.97769 3.3818 2.00211 3.16204C2.02652 2.94229 2.07536 2.69404 2.14861 2.41731C2.22186 2.14059 2.32769 1.84758 2.46603 1.53829L2.67358 1.07436L2.68579 1.03774L2.698 1.00111L2.70535 0.996226L2.71021 0.988901L2.71509 0.981576L2.72242 0.976693L2.72977 0.981576L2.73463 0.988901L2.73951 0.996226L2.74683 1.00111L2.75418 1.00599L2.75904 1.01332L2.76393 1.02064L2.77125 1.02553L2.78346 1.04994L2.79567 1.07436L2.80302 1.07925L2.80788 1.08657L3.13751 1.45283C3.35727 1.697 3.61773 1.96967 3.91887 2.27081C4.22003 2.57195 4.38687 2.72822 4.41942 2.73962C4.45199 2.75264 4.49267 2.79007 4.54151 2.85194C4.59034 2.91218 4.75313 3.05624 5.02985 3.28413C5.3066 3.51202 5.66878 3.77655 6.11642 4.07769C6.56409 4.37883 7.06057 4.67592 7.60588 4.96892C8.15122 5.26193 8.73723 5.52644 9.36393 5.76249C9.99065 5.99853 10.4302 6.15316 10.6825 6.22642C10.9348 6.29967 11.3661 6.39326 11.9766 6.50721C12.587 6.62117 13.0469 6.69442 13.3562 6.72697C13.6655 6.75952 13.8771 6.77825 13.991 6.78313L14.1619 6.78801L14.1571 6.75139L14.1497 6.71476L14.1009 6.40955C14.0683 6.20608 14.0521 5.9212 14.0521 5.55494C14.0521 5.18868 14.0805 4.85091 14.1375 4.54162C14.1945 4.23233 14.28 3.91898 14.3939 3.60155C14.5078 3.28413 14.6194 3.02936 14.7284 2.83729C14.8391 2.64684 14.984 2.42952 15.163 2.18535C15.3421 1.94118 15.5741 1.68887 15.8589 1.42841C16.1438 1.16795 16.4694 0.935989 16.8356 0.732519C17.2019 0.52905 17.5397 0.374391 17.8489 0.26859C18.1582 0.16279 18.4187 0.0935916 18.6303 0.0610433C18.8419 0.028495 18.9477 0.00976693 18.9477 0.00488346Z" fill="#D8D8D8"/>
								</svg>

							</a>
						</li>
						<li>
							<a href="#">
								<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M3.95019 0.577544C4.64899 0.305624 5.44918 0.119944 6.62019 0.066616C7.79367 0.012408 8.16891 0 11.1562 0C14.1434 0 14.5184 0.013288 15.6912 0.066616C16.8614 0.119064 17.6611 0.305624 18.3612 0.577544C19.0836 0.858352 19.6977 1.23411 20.3089 1.84633C20.9202 2.45854 21.2961 3.07164 21.5777 3.79491C21.8496 4.49372 22.0353 5.29382 22.0887 6.46492C22.142 7.63778 22.1544 8.01275 22.1544 11C22.1544 13.9872 22.142 14.3613 22.0887 15.5351C22.0362 16.7061 21.8496 17.5058 21.5777 18.2051C21.2961 18.9284 20.9212 19.5424 20.3089 20.1537C19.6967 20.7649 19.0836 21.1409 18.3604 21.4225C17.6611 21.6944 16.8615 21.8801 15.6904 21.9334C14.5175 21.9876 14.1425 22 11.1553 22C8.16803 22 7.79367 21.9867 6.62019 21.9334C5.44918 21.8801 4.65031 21.6944 3.95019 21.4225C3.22647 21.1409 2.61373 20.7647 2.0016 20.1537C1.38947 19.5427 1.01363 18.9284 0.732817 18.2051C0.460897 17.5058 0.275217 16.7062 0.221889 15.5351C0.167681 14.3622 0.155273 13.9872 0.155273 11C0.155273 8.01275 0.167681 7.63778 0.221889 6.46492C0.275217 5.2939 0.460897 4.49416 0.732817 3.79491C1.01363 3.0712 1.38939 2.45758 2.0016 1.84633C2.61382 1.23508 3.22647 0.858352 3.95019 0.577544ZM6.71137 19.9565C5.63891 19.9077 5.056 19.729 4.66862 19.5781C4.15506 19.3782 3.78862 19.1401 3.40336 18.7553C3.0181 18.3706 2.77962 18.0045 2.58056 17.4909C2.42955 17.1037 2.25091 16.5207 2.20216 15.4482C2.14883 14.2887 2.13818 13.9404 2.13818 11.0029C2.13818 8.06535 2.14971 7.71802 2.20216 6.55756C2.251 5.4851 2.43096 4.90316 2.58056 4.51481C2.7805 4.00125 3.01862 3.63481 3.40336 3.24955C3.7881 2.86429 4.15418 2.62581 4.66862 2.42675C5.05582 2.27574 5.63891 2.0971 6.71137 2.04835C7.87086 1.99502 8.21916 1.98438 11.1554 1.98438C14.0916 1.98438 14.4402 1.9959 15.6007 2.04835C16.6731 2.09719 17.2551 2.27715 17.6434 2.42675C18.157 2.62581 18.5234 2.86481 18.9087 3.24955C19.294 3.63429 19.5316 4.00125 19.7315 4.51481C19.8825 4.90202 20.0611 5.4851 20.1099 6.55756C20.1632 7.71802 20.1739 8.06535 20.1739 11.0029C20.1739 13.9404 20.1632 14.2877 20.1099 15.4482C20.0611 16.5207 19.8815 17.1036 19.7315 17.4909C19.5316 18.0045 19.2934 18.3709 18.9087 18.7553C18.524 19.1397 18.157 19.3782 17.6434 19.5781C17.2562 19.7291 16.6731 19.9078 15.6007 19.9565C14.4412 20.0099 14.0929 20.0205 11.1554 20.0205C8.21784 20.0205 7.8705 20.0099 6.71137 19.9565ZM17.0265 6.4525C16.2975 6.45221 15.7067 5.86099 15.707 5.13197C15.7077 4.4033 16.2984 3.81284 17.027 3.8125H17.0276C17.7566 3.81279 18.3473 4.40401 18.347 5.13303C18.3467 5.86204 17.7555 6.45279 17.0265 6.4525ZM5.50732 10.9999C5.50732 14.1195 8.03609 16.6483 11.1557 16.6483C14.2753 16.6483 16.8041 14.1195 16.8041 10.9999C16.8041 7.88033 14.2753 5.35156 11.1557 5.35156C8.03609 5.35156 5.50732 7.88033 5.50732 10.9999ZM7.48926 11.0029C7.48926 8.97793 9.13037 7.33594 11.1553 7.33594C13.1803 7.33594 14.8223 8.97793 14.8223 11.0029C14.8223 13.0279 13.1803 14.6699 11.1553 14.6699C9.13037 14.6699 7.48926 13.0279 7.48926 11.0029Z" fill="#D8D8D8"/>
								</svg>

							</a>
						</li>
						<li>
							<a href="#">
								<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M0.956055 10.9989C0.956055 4.92433 5.88039 0 11.955 0C18.0294 0 22.9538 4.92433 22.9539 10.9989C22.9539 17.0735 18.0295 21.9978 11.955 21.9978C5.88039 21.9978 0.956055 17.0735 0.956055 10.9989ZM6.60596 16.3175H9.02088V8.51562H6.60596V16.3175ZM7.80159 7.48859C7.0129 7.48859 6.37354 6.84401 6.37354 6.04901C6.37354 5.25391 7.01299 4.60938 7.80159 4.60938C8.59019 4.60938 9.22956 5.25391 9.22956 6.04901C9.2296 6.84405 8.59023 7.48859 7.80159 7.48859ZM15.6671 16.3211H18.0703L18.0703 11.3811C18.0703 9.29139 16.8861 8.28125 15.2317 8.28125C13.5773 8.28125 12.8806 9.57002 12.8806 9.57002V8.51923H10.5645V16.3211H12.8806V12.2258C12.8806 11.1286 13.3856 10.4756 14.3523 10.4756C15.2404 10.4756 15.6671 11.1026 15.6671 12.2258V16.3211Z" fill="#D8D8D8"/>
								</svg>

							</a>
						</li>
						<li>
							<a href="#">
								<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M4.57139 21.1168C5.78703 21.3673 7.76478 21.4632 13.5553 21.5698C18.3846 21.6471 22.6396 21.5653 27.6505 21.1884C28.4513 21.051 29.1912 20.6728 29.7715 20.1042C30.1416 19.7348 30.3554 19.4014 30.6059 18.7696C31.0109 17.7689 31.1542 16.8037 31.3324 14.0757C31.3798 13.2532 31.3798 8.58301 31.3324 7.76055C31.3212 7.5913 31.3109 7.41742 31.3003 7.23979C31.2034 5.60579 31.0875 3.65362 30.07 2.05296C29.5453 1.36193 28.6518 0.826034 27.699 0.647213C26.5065 0.421008 21.4194 0.242188 16.1767 0.242188C10.9221 0.242188 5.84626 0.421008 4.65488 0.647213C3.89221 0.789931 3.21303 1.13516 2.62919 1.67162C1.5094 2.70967 1.32967 4.41899 1.16747 5.96167C1.15056 6.12248 1.13384 6.28148 1.11626 6.43773C0.890623 9.4348 0.934059 12.1171 1.11626 15.3979C1.23529 16.8516 1.31878 17.4468 1.53314 18.162C1.78303 19.0206 2.10514 19.6394 2.51016 20.045C3.03421 20.5809 3.74893 20.9504 4.57139 21.1168ZM21.2238 10.6112C21.2254 10.6121 21.227 10.6129 21.2287 10.6138L21.2405 10.6019C21.2349 10.605 21.2294 10.6081 21.2238 10.6112ZM21.2238 10.6112C19.2032 9.53141 17.2448 8.50849 15.2808 7.4827C14.5369 7.09413 13.7922 6.70514 13.043 6.3125V14.8677C14.4642 14.0951 15.9236 13.3545 17.314 12.649C18.7258 11.9326 20.0664 11.2523 21.2238 10.6112Z" fill="#D8D8D8"/>
								</svg>

							</a>
						</li>
					</ul>
				</div>
				<div class="footer-link">
					<span class="footer-head">Solutions</span>
					<ul>
						<li><a href="#">Digital Menu</a></li>
						<li><a href="#">Qr Code Menu</a></li>
						<li><a href="#">Admin Dashboard</a></li>
					</ul>
				</div>
				<div class="footer-link">
					<span class="footer-head">Quick Links</span>
					<ul>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Careers</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div>
				<div class="footer-link">
					<span class="footer-head">Contact Us</span>
					<ul>
						<li>
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_310_623)">
							<path d="M10 0C5.865 0 2.5 3.38833 2.5 7.55417C2.5 13.4733 9.295 19.585 9.58417 19.8417C9.69846 19.944 9.84644 20.0006 9.99984 20.0008C10.1532 20.0009 10.3013 19.9446 10.4158 19.8425C10.705 19.585 17.5 13.4733 17.5 7.55417C17.5 3.38833 14.135 0 10 0ZM10 11.6667C7.7025 11.6667 5.83333 9.7975 5.83333 7.5C5.83333 5.2025 7.7025 3.33333 10 3.33333C12.2975 3.33333 14.1667 5.2025 14.1667 7.5C14.1667 9.7975 12.2975 11.6667 10 11.6667Z" fill="white"/>
							</g>
							<defs>
							<clipPath id="clip0_310_623">
							<rect width="20" height="20" fill="white"/>
							</clipPath>
							</defs>
							</svg>
							<span>
								A-325, First Floor, Noida, Greater Noida -110030. Near Pari Chawk
							</span>
						</li>
						<li>
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.9582 10.8281L11.2832 12.5088C10.6039 13.1905 9.40875 13.2052 8.7148 12.5088L7.03969 10.8281L1.02344 16.8639C1.24738 16.9675 1.4943 17.0293 1.7568 17.0293H18.2412C18.5037 17.0293 18.7505 16.9675 18.9744 16.8639L12.9582 10.8281Z" fill="white"/>
							<path d="M18.2422 2.96875H1.75781C1.49531 2.96875 1.2484 3.03055 1.02453 3.1341L7.45332 9.58422C7.45375 9.58465 7.45426 9.58473 7.45469 9.58516C7.45495 9.58544 7.45513 9.58579 7.4552 9.58617L9.54555 11.6834C9.76758 11.9055 10.2325 11.9055 10.4545 11.6834L12.5445 9.58652C12.5445 9.58652 12.545 9.58559 12.5454 9.58516C12.5454 9.58516 12.5463 9.58465 12.5468 9.58422L18.9754 3.13406C18.7515 3.03047 18.5047 2.96875 18.2422 2.96875ZM0.186953 3.95359C0.0710937 4.18789 0 4.44797 0 4.72656V15.2734C0 15.552 0.0710156 15.8121 0.186914 16.0464L6.21359 10.0002L0.186953 3.95359ZM19.813 3.95352L13.7864 10.0002L19.813 16.0465C19.9289 15.8122 20 15.5521 20 15.2734V4.72656C20 4.44789 19.9289 4.18781 19.813 3.95352Z" fill="white"/>
							</svg>
							<span>
								info@digitalqr.com
							</span>
						</li>
						<li>
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_310_612)">
							<path d="M18.3952 13.1277C17.1707 13.1277 15.9684 12.9362 14.8291 12.5597C14.2708 12.3693 13.5845 12.544 13.2438 12.8939L10.995 14.5915C8.38703 13.1994 6.78057 11.5934 5.40745 9.00505L7.0551 6.81484C7.48318 6.38734 7.63672 5.76286 7.45276 5.17693C7.07464 4.03161 6.88255 2.8299 6.88255 1.6049C6.8826 0.719948 6.16266 0 5.27776 0H1.60484C0.719948 0 0 0.719948 0 1.60484C0 11.7481 8.25198 20 18.3952 20C19.2801 20 20.0001 19.2801 20.0001 18.3952V14.7325C20 13.8477 19.2801 13.1277 18.3952 13.1277Z" fill="white"/>
							</g>
							<defs>
							<clipPath id="clip0_310_612">
							<rect width="20" height="20" fill="white"/>
							</clipPath>
							</defs>
							</svg>
							<span>
								+91-7081000740
							</span>
						</li>
					</ul>
				</div>
			</div>
		
			<div class="copyright-wrap">
				<ul>
					<li><a href="{{ url('terms-and-conditions') }}">Terms of Services</a></li>
					<li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
					<!-- <li><a href="#">Cookies Police</a></li> -->
				</ul>
				<span>© 2025 DigitalQR. All Rights Reserved</span>
			</div>
		</div>
	</footer>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js'></script>
	<script>
		jQuery(document).ready(function ($) {
			var owl = $("#owl-demo-2");
			owl.owlCarousel({
				autoplay: true,
				autoplayTimeout: 1000,
				autoplayHoverPause: true,
				items: 3,
				loop: true,   
				center: false,
				rewind: false,
				mouseDrag: true,
				touchDrag: true,
				pullDrag: true,
				freeDrag: false,
				margin: 34,
				stagePadding: 0,
				merge: false,
				mergeFit: true,
				autoWidth: false,
				startPosition: 0,
				rtl: false,
				smartSpeed: 250,
				fluidSpeed: false,
				dragEndSpeed: false,
				responsive: {
					0: {
						items: 1
						// nav: true
					},
					480: {
						items: 1,
						nav: false
					},
					768: {
						items: 1,
						// nav: true,
						loop: false
					},
					992: {
						items: 3,
						// nav: true,
						loop: false
					}
				},
				responsiveRefreshRate: 200,
				responsiveBaseElement: window,
				fallbackEasing: "swing",
				info: false,
				nestedItemSelector: false,
				itemElement: "div",
				stageElement: "div",
				refreshClass: "owl-refresh",
				loadedClass: "owl-loaded",
				loadingClass: "owl-loading",
				rtlClass: "owl-rtl",
				responsiveClass: "owl-responsive",
				dragClass: "owl-drag",
				itemClass: "owl-item",
				stageClass: "owl-stage",
				stageOuterClass: "owl-stage-outer",
				grabClass: "owl-grab",
				autoHeight: false,
				lazyLoad: false
			});

			$(".next").click(function () {
				owl.trigger("owl.next");
			});
			$(".prev").click(function () {
				owl.trigger("owl.prev");
			});
		});
	</script>
    <script>
        (function($) {
          'use strict';

          // call our plugin
          var Nav = new hcOffcanvasNav('#main-nav', {
            disableAt: false,
            customToggle: '.toggle',
            levelSpacing: 40,
            navTitle: 'All Categories',
            levelTitles: true,
            levelTitleAsBack: true,
            pushContent: '#container',
            labelClose: false
          });

          // add new items to original nav
          $('#main-nav').find('li.add').children('a').on('click', function() {
            var $this = $(this);
            var $li = $this.parent();
            var items = eval('(' + $this.attr('data-add') + ')');

            $li.before('<li class="new"><a href="#">'+items[0]+'</a></li>');

            items.shift();

            if (!items.length) {
              $li.remove();
            }
            else {
              $this.attr('data-add', JSON.stringify(items));
            }

            Nav.update(true); // update DOM
          });

          // demo settings update

          const update = function(settings) {
            if (Nav.isOpen()) {
              Nav.on('close.once', function() {
                Nav.update(settings);
                Nav.open();
              });

              Nav.close();
            }
            else {
              Nav.update(settings);
            }
          };

          $('.actions').find('a').on('click', function(e) {
            e.preventDefault();

            var $this = $(this).addClass('active');
            var $siblings = $this.parent().siblings().children('a').removeClass('active');
            var settings = eval('(' + $this.data('demo') + ')');

            if ('theme' in settings) {
              $('body').removeClass().addClass('theme-' + settings['theme']);
            }
            else {
              update(settings);
            }
          });

          $('.actions').find('input').on('change', function() {
            var $this = $(this);
            var settings = eval('(' + $this.data('demo') + ')');

            if ($this.is(':checked')) {
              update(settings);
            }
            else {
              var removeData = {};
              $.each(settings, function(index, value) {
                removeData[index] = false;
              });

              update(removeData);
            }
          });
        })(jQuery);
    </script>
</body>
</html>
