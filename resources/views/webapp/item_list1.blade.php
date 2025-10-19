@extends('webapp.default')
@section('pageTitle', 'Clone Existing Menu')
@section('content')
<section class="topSingleBkg topPageBkg">
   <div class="item-content-bkg">
      <div class="item-img" style="background-image: url('{{ asset('qr-webapp/images/top-headers/menu-1col-image.jpg') }}');"></div>
      <div class="inner-desc">
         <span class="post-subtitle">Our Menu</span>
      </div>
   </div>
</section>
<section class="menu-1col-content">
   <div class="container">
      <div class="row">
         <div class="col-md-10 offset-md-1">
            @if(count($menuCategories) > 0)
            @foreach($menuCategories as $category)
            @if($category->vendorMenus->count() > 0)
            <!-- CATEGORY NAME -->
            <div class="categ-name">
               <h2>{{ $category->name }}</h2>
            </div>
            <div class="menu-holder menu-1col">
               @foreach($category->vendorMenus as $menu)
               <div class="menu-post clearfix">
                  <!-- MENU IMAGE -->
                  <div class="menu-post-img">
                     <a href="{{ asset($menu->image ?? 'qr-webapp/images/default.png') }}" 
                        class="lightbox" 
                        title="{{ $menu->name }}">
                     <img width="400" height="400" 
                        src="{{ asset($menu->image ?? 'qr-webapp/images/default.png') }}" 
                        alt="{{ $menu->name }}" 
                        style="object-fit: cover;border: 2px solid black;">
                     </a>
                  </div>
                  <!-- MENU DESCRIPTION -->
                  <div class="menu-post-desc">
                     <h4>
                        <span class="menu-title">{{ $menu->name }}</span> 
                        <span class="menu-dots"></span>
                        <span class="menu-price">
                        ₹{{ $menu->price_full }} 
                        @if($menu->price_half) / ₹{{ $menu->price_half }} @endif
                        </span>
                     </h4>
                     <div class="menu-text">{{ $menu->description }}</div>
                  </div>
               </div>
               @endforeach
            </div>
            <!--menu-1col-->
            @endif
            @endforeach
            @else
            <p class="text-center">No menu items available.</p>
            @endif
         </div>
         <!--col-md-10-->
      </div>
      <!--row-->
   </div>
   <!--container-->
</section>
@endsection