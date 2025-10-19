@extends('vendor.layouts.default')
@section('pageTitle', 'Digital QR Setup')

@section('content')
<div class="container">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"> Customize Your Digital Menu </h1>
    </div>


    <div class="row justify-content-center">
        <!-- Customization Form -->
        <div class="col-md-7 mb-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Menu Settings</h5>
                <form id="menuForm">
                    <!-- Restaurant Name -->
                    <div class="form-group">
                        <label for="restaurantName">Restaurant Name:</label>
                        <input type="text" id="restaurantName" class="form-control" value="My Restaurant">
                    </div>

                    <!-- Tagline -->
                    <div class="form-group">
                        <label for="tagline">Tagline:</label>
                        <input type="text" id="tagline" class="form-control" value="Delicious Food Awaits!">
                    </div>

                    <!-- Background Color -->
                    <div class="form-group">
                        <label for="bgColor">Background Color:</label>
                        <input type="color" id="bgColor" class="form-control" value="#f8f9fa">
                    </div>

                    <!-- Text Color -->
                    <div class="form-group">
                        <label for="textColor">Text Color:</label>
                        <input type="color" id="textColor" class="form-control" value="#000000">
                    </div>

                    <!-- Width & Height -->
                  <div class="form-group d-flex align-items-center">
                    <label for="menuWidth" class="mr-2">Width (px):</label>
                    <input type="number" id="menuWidth" class="form-control w-50" value="400">

                    <label for="menuHeight" class="ml-3 mr-2">Height (px):</label>
                    <input type="number" id="menuHeight" class="form-control w-50" value="600">
                  </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" id="printBtn" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="col-md-5 mb-4">
            <div class="card p-4 shadow">
                <h5 class="text-center">Live Preview</h5>
                <div id="menuPreview" class="p-4 text-center d-flex flex-column align-items-center justify-content-center" 
                     style="width: 400px; height: 435px; background: #f8f9fa; color: #000; border-radius: 10px;">
                    <h2 id="previewRestaurantName" class="text-center" style="font-weight: bold;">My Restaurant</h2>
                    <p id="previewTagline" class="text-center">Delicious Food Awaits!</p>
                    <div class="qr-container mt-3">
                        {!! QrCode::size(150)->generate(url('/menu-items/' . Auth::user()->code)) !!}
                    </div>
                    <p class="mt-3">Scan to View Menu & Prices</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS for Live Preview, Download & Print -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuPreview = document.getElementById("menuPreview");
        const restaurantNameInput = document.getElementById("restaurantName");
        const taglineInput = document.getElementById("tagline");
        const bgColorInput = document.getElementById("bgColor");
        const textColorInput = document.getElementById("textColor");
        const menuWidthInput = document.getElementById("menuWidth");
        const menuHeightInput = document.getElementById("menuHeight");

        // Update live preview
        function updatePreview() {
            document.getElementById("previewRestaurantName").textContent = restaurantNameInput.value;
            document.getElementById("previewTagline").textContent = taglineInput.value;
            menuPreview.style.backgroundColor = bgColorInput.value;
            menuPreview.style.color = textColorInput.value;
            menuPreview.style.width = menuWidthInput.value + "px";
            menuPreview.style.height = menuHeightInput.value + "px";
        }

        restaurantNameInput.addEventListener("input", updatePreview);
        taglineInput.addEventListener("input", updatePreview);
        bgColorInput.addEventListener("input", updatePreview);
        textColorInput.addEventListener("input", updatePreview);
        menuWidthInput.addEventListener("input", updatePreview);
        menuHeightInput.addEventListener("input", updatePreview);

        // Print Function
        document.getElementById("printBtn").addEventListener("click", function() {
            let printWindow = window.open("", "", "width=800,height=900");
            printWindow.document.write('<html><head><title>Print Menu</title></head><body>');
            printWindow.document.write(menuPreview.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });


    });
</script>

<!-- Include html2canvas for Download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
@endsection
