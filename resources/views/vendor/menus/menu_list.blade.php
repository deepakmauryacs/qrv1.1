<style type="text/css">
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-body {
    padding: 16px 20px;
}

.img-thumbnail {
    border-radius: 10px; /* Rounded corners for the image */
    margin-right: 16px; /* Gap between the image and text */
}

.card-body h6 {
    font-size: 16px; /* Increase font size for better visibility */
}

.card-body .btn {
    font-size: 14px; /* Slightly smaller button text */
    padding: 8px 16px; /* Increase padding for a more modern feel */
}

/* Add padding and spacing around the elements for better alignment */
.card-body {
    align-items: center;
    justify-content: space-between;
}
.card-body .ms-3 {
    margin-left: 12px;
}
/* Additional styling for hover effect on button */
.card-body .add-menu-btn:hover {
    background-color: #28a745;
    border-color: #28a745;
}
/* Dot styling for veg and non-veg */
/* Styling for veg and non-veg icons */
.icon {
    margin-right: 8px; /* Space between the icon and text */
}
.icon.veg {
    color: green;
}
.icon.non-veg {
    color: red; /* Red for non-veg */
}
/* SVG icon styling */
.bi-leaf {
    width: 14px;
    height: 14px;
}
</style>
@foreach($menus as $menu)
<div class="col-md-4 mb-4">
    <div class="card shadow border-0">
        <div class="card-body d-flex align-items-center">
            <!-- Image -->
             @if($menu->image)
              <img src="{{ asset($menu->image) }}" alt="Menu Image" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
             @else
               <img src="{{ asset('icon/placeholder.png') }}" alt="Menu Image" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
             @endif
            <!-- Menu Name and Type -->
            <div class="ms-3">
                <h6 class="m-0" style="font-weight: 600;">{{ $menu->name }}</h6>
                <!-- Green or Red dot based on menu type -->
                <!-- SVG for Veg or Non-Veg -->
                   
                        <!-- Green Veg Icon (SVG) -->
                        @if($menu->menu_type == 'veg')
                           <img src="{{ asset('icon/veg-icon.png') }}" alt="Menu Image"  style="width: 25px; height: 25px;">
                        @else
                          <img src="{{ asset('icon/non-veg-icon.png') }}" alt="Menu Image" style="width: 25px; height: 25px;">
                        @endif 


                 
                <small class="text-muted">{{ $menu->menu_type }}</small>
            </div>

            <!-- Add Button -->
            <button class="btn btn-success btn-sm ms-auto add-menu-btn" data-id="{{ $menu->id }}">
                <i class="bi {{ in_array($menu->name, $vendor_menus) ? 'bi-check' : 'bi-plus-circle' }}"></i> {{ in_array($menu->name, $vendor_menus) ? "Added" : "Add" }}
            </button>
        </div>
    </div>
</div>
@endforeach
