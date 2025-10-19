@extends('vendor.layouts.default')
@section('pageTitle', 'Profile Settings')
@section('content')
<style type="text/css">
.iti {
  width: 100% !important;
}
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"> Profile Setting </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Setting Details</h6>
        </div>
        <div class="card-body">
         <form id="settingForm" action="{{ route('vendor.settings.saveOrUpdate') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @if(isset($setting))
                    @method('PUT')
                @endif

                <div class="row">
           

                    <!-- Store Logo -->
                    <div class="col-md-6 mb-3">
                        <label for="store_logo" class="form-label">Store Logo</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control d-none" id="store_logo" name="store_logo" accept="image/*" onchange="previewLogo(event)">
                            <label for="store_logo" class="upload-label">
                                <i class="bi bi-cloud-upload"></i> Click to Upload
                            </label>
                            <div class="preview-container mt-2">
                                <img id="logoPreview" class="img-thumbnail {{ isset($setting) && $setting->store_logo ? '' : 'd-none' }}" style="max-width: 100px; max-height: 100px;" src="{{ isset($setting) && $setting->store_logo ? asset('/'.$setting->store_logo) : '' }}" alt="Store Logo">
                            </div>
                        </div>
                    </div>

                    <!-- Store Name -->
                    <div class="col-md-6 mb-3">
                        <label for="store_name" class="form-label">Store Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="store_name" name="store_name" value="{{ old('store_name', $setting->store_name ?? '') }}">
                    </div>

                    <!-- Country -->
                    <div class="col-md-6 mb-3">
                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-control" id="country" name="country" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}" 
                                    {{ old('country', $setting->country ?? '') == $country->name ? 'selected' : '' }}>
                                    {{ $country->name }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- State Dropdown -->
                    <div class="col-md-6 mb-3">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-control" id="state" name="state" required>
                            <option value="">Select State</option>
                            @if(!empty($setting->state))
                                <option value="{{ old('state', $setting->state) }}" selected>
                                    {{ old('state', $setting->state) }}
                                </option>
                            @endif
                        </select>
                    </div>

                    <!-- State -->
                    <!--  <div class="col-md-6 mb-3">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $setting->state ?? '') }}">
                     </div> -->

                    <!-- City -->
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $setting->city ?? '') }}">
                    </div>

                    <!-- Store Address -->
                    <div class="col-md-12 mb-3">
                        <label for="store_address" class="form-label">Store Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="store_address" name="store_address" rows="3">{{ old('store_address', $setting->store_address ?? '') }}</textarea>
                    </div>

                    <!-- Store Latitude -->
                    <div class="col-md-6 mb-3">
                        <label for="store_lat" class="form-label">Store Latitude <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="store_lat" name="store_lat" value="{{ old('store_lat', $setting->store_lat ?? '') }}">
                    </div>

                    <!-- Store Longitude -->
                    <div class="col-md-6 mb-3">
                        <label for="store_long" class="form-label">Store Longitude <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="store_long" name="store_long" value="{{ old('store_long', $setting->store_long ?? '') }}">
                    </div>

                    <!-- Dine In -->
                    <div class="col-md-6 mb-3">
                        <label for="dine_in" class="form-label">Dine In <span class="text-danger">*</span></label>
                        <select class="form-control" id="dine_in" name="dine_in">
                            <option value="">Select Option</option>
                            <option value="1" {{ old('dine_in', $setting->dine_in ?? '') == 1 ? 'selected' : '' }}>ON</option>
                            <option value="2" {{ old('dine_in', $setting->dine_in ?? '') == 2 ? 'selected' : '' }}>OFF</option>
                        </select>
                    </div>

                    <!-- Store Email -->
                    <div class="col-md-6 mb-3">
                        <label for="store_email" class="form-label">Store Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="store_email" name="store_email" value="{{ old('store_email', $setting->store_email ?? '') }}">
                    </div>

                    <!-- Store Contact -->
                    <!-- Include intl-tel-input CSS -->
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

                    <div class="col-md-6 mb-3">
                        <label for="store_contact" class="form-label">Store Contact <span class="text-danger">*</span></label><br>
                        <input type="tel" class="form-control" id="store_contact" name="store_contact" 
                               value="{{ old('store_contact', $setting->store_contact ?? '') }}">
                    </div>

                    <!-- Include intl-tel-input JS -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var input = document.querySelector("#store_contact");
                            var iti = window.intlTelInput(input, {
                                separateDialCode: true, // Show country code separately
                                preferredCountries: ["in", "us", "ae", "gb"], // India 🇮🇳, USA 🇺🇸, UAE 🇦🇪 (Dubai), UK 🇬🇧
                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                            });

                            // Retrieve the stored country code from the database
                            var storedCountryCode = "{{ old('country_code', $setting->country_code ?? '+91') }}".replace('+', '');

                            // Get country data correctly
                            var countryData = intlTelInputGlobals.getCountryData().find(country => country.dialCode === storedCountryCode);

                            if (countryData) {
                                iti.setCountry(countryData.iso2); // Set the country in the input field
                            }

                            // Ensure country code is included in form submission
                            input.form.addEventListener("submit", function () {
                                var hiddenInput = document.createElement("input");
                                hiddenInput.type = "hidden";
                                hiddenInput.name = "country_code";
                                hiddenInput.value = "+" + iti.getSelectedCountryData().dialCode;
                                input.form.appendChild(hiddenInput);
                            });
                        });
                    </script>

                    <!-- Opening Time -->
                    <div class="col-md-3 mb-3">
                        <label for="opening_time" class="form-label">Opening Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="opening_time" name="opening_time" 
                               value="{{ old('opening_time', $setting->opening_time ?? '') }}">
                    </div>

                    <!-- Closing Time -->
                    <div class="col-md-3 mb-3">
                        <label for="closing_time" class="form-label">Closing Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="closing_time" name="closing_time" 
                               value="{{ old('closing_time', $setting->closing_time ?? '') }}">
                    </div>



                    <div class="col-md-6 mb-3">
                        <label for="timezone" class="form-label">Timezone <span class="text-danger">*</span></label>
                        <select class="form-control" id="timezone" name="timezone">
                            <option value="">Select Option</option>
                            @foreach($timezones as $timezone)
                                <option value="{{ $timezone->id }}" 
                                    {{ (!empty($setting->timezone) ? $setting->timezone : '20') == $timezone->id ? 'selected' : '' }}>
                                    {{ $timezone->timezone. ' (' .$timezone->gmt_offset.')' }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i> {{ isset($setting) ? 'Update Setting' : 'Save Setting' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery & AJAX submission with client-side validation -->
<script>
    $(document).ready(function() {
    $('#settingForm').submit(function(e) {
        e.preventDefault();

        var isValid = true;

        // Simple client-side validation
        if ($('#store_name').val() === '') {
            toastr.error("Please enter store name.");
            isValid = false;
        }
        if ($('#country').val() === '') {
            toastr.error("Please enter country.");
            isValid = false;
        }
        if ($('#state').val() === '') {
            toastr.error("Please enter state.");
            isValid = false;
        }
        if ($('#city').val() === '') {
            toastr.error("Please enter city.");
            isValid = false;
        }
        if ($('#store_address').val() === '') {
            toastr.error("Please enter store address.");
            isValid = false;
        }
        if ($('#store_lat').val() === '') {
            toastr.error("Please enter store latitude.");
            isValid = false;
        }
        if ($('#store_long').val() === '') {
            toastr.error("Please enter store longitude.");
            isValid = false;
        }
        if ($('#dine_in').val() === '') {
            toastr.error("Please select a dine-in option.");
            isValid = false;
        }
        if ($('#store_email').val() === '') {
            toastr.error("Please enter store email.");
            isValid = false;
        }
        if ($('#store_contact').val() === '') {
            toastr.error("Please enter store contact.");
            isValid = false;
        }
        if ($('#timezone').val() === '') {
            toastr.error("Please select timezone.");
            isValid = false;
        }

        if (isValid) {
            let formData = new FormData(this);
            let submitButton = $('button[type="submit"]');

            // Disable the button and show a spinner
            submitButton.prop('disabled', true);
            submitButton.html('<i class="bi bi-hourglass-split spin"></i> Saving...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.href = "{{ route('vendor.settings.index') }}";
                        }, 300);
                    } else {
                        $.each(response.message, function(index, error) {
                            toastr.error(error);
                        });
                    }

                    // Re-enable the button after success/error
                    submitButton.prop('disabled', false);
                    submitButton.html('<i class="bi bi-floppy"></i> {{ isset($setting) ? "Update Setting" : "Save Setting" }}');
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);

                    // Re-enable the button after error
                    submitButton.prop('disabled', false);
                    submitButton.html('<i class="bi bi-floppy"></i> {{ isset($setting) ? "Update Setting" : "Save Setting" }}');
                }
            });
        }
    });
});

// Preview uploaded logo image
function previewLogo(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('logoPreview');
        output.src = reader.result;
        output.classList.remove('d-none');
    };
    reader.readAsDataURL(event.target.files[0]);
}


$(document).ready(function () {
    $('#country').on('change', function () {
        var country_name = $(this).val();

        if (country_name) {
            $.ajax({
                url: "{{ route('getStatesByCountryName') }}",
                type: "GET",
                data: { country_name: country_name },
                success: function (data) {
                    $('#state').empty();
                    $('#state').append('<option value="">Select State</option>');
                    $.each(data, function (key, value) {
                        $('#state').append('<option value="' + value.name + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#state').empty();
            $('#state').append('<option value="">Select State</option>');
        }
    });
});
</script>
@endsection
