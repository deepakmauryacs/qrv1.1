@extends('default') 
@section('title', 'Contact Us - Digital QR')
@section('content')

<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="contact-sect">
   <div class="container">
      <div class="contact-wrap">
         <div class="contact-left">
            <div class="cl-top-wrap">
               <h2>Contact Us</h2>
               <p>
                  Want to learn more about Digital QR, set up your digital menu, or get assistance? Let us know what you need, and we’ll get back to you right away.
               </p>
               <div class="ct-num-id">
                  <a href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths">
                        <g>
                           <path d="m331.756 277.251-42.881 43.026c-17.389 17.45-47.985 17.826-65.75 0l-42.883-43.026L26.226 431.767C31.959 434.418 38.28 436 45 436h422c6.72 0 13.039-1.58 18.77-4.232L331.756 277.251z" fill="#000000" opacity="1" data-original="#000000" class="hovered-path"></path>
                           <path d="M467 76H45c-6.72 0-13.041 1.582-18.772 4.233l164.577 165.123c.011.011.024.013.035.024a.05.05 0 0 1 .013.026l53.513 53.69c5.684 5.684 17.586 5.684 23.27 0l53.502-53.681s.013-.024.024-.035c0 0 .024-.013.035-.024L485.77 80.232C480.039 77.58 473.72 76 467 76zM4.786 101.212C1.82 107.21 0 113.868 0 121v270c0 7.132 1.818 13.79 4.785 19.788l154.283-154.783L4.786 101.212zM507.214 101.21 352.933 256.005 507.214 410.79C510.18 404.792 512 398.134 512 391V121c0-7.134-1.82-13.792-4.786-19.79z" fill="#000000" opacity="1" data-original="#000000" class="hovered-path"></path>
                        </g>
                     </svg>
                     <span>info@digitalqr.com</span>
                  </a>
                  <a href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 513.64 513.64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                           <path d="m499.66 376.96-71.68-71.68c-25.6-25.6-69.12-15.359-79.36 17.92-7.68 23.041-33.28 35.841-56.32 30.72-51.2-12.8-120.32-79.36-133.12-133.12-7.68-23.041 7.68-48.641 30.72-56.32 33.28-10.24 43.52-53.76 17.92-79.36l-71.68-71.68c-20.48-17.92-51.2-17.92-69.12 0L18.38 62.08c-48.64 51.2 5.12 186.88 125.44 307.2s256 176.641 307.2 125.44l48.64-48.64c17.921-20.48 17.921-51.2 0-69.12z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                     </svg>
                     <span>+91-7081000740</span>
                  </a>
               </div>
            </div>
            <div class="cl-bottom-wrap">
               <div class="contact-bottom">
                  <div class="contact-box">
                     <span>Customer Support</span>
                     <p>
                        Our support team is available around the clock to address any concerns or queries you may have
                     </p>
                  </div>
                  <div class="contact-box">
                     <span>Media Inquiries</span>
                     <p>
                        For medle-related questions or press inquiries, please contact us at <a href="#">infor@digitalqr.com</a>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="contact-right">
            <div class="contact-form">
               <form class="row contact-form" method="POST" id="contact-form">
                  @csrf
                  <h3>Get in Touch</h3>
                  <span>You can reach us anytime</span>
                  <div class="form-fld-cover">
                     <div class="form-group">
                        <input type="text" name="name" id="name" placeholder="First Name">
                        <!-- <input type="text" placeholder="Last Name"> -->
                     </div>
                     <div class="form-group">
                        <input type="text" placeholder="Email" name="email" id="email">
                     </div>
                     <div class="form-group">
                        <textarea name="message" id="message"></textarea>
                     </div>
                     <div class="form-group">
                        <label> Solve: <span id="captcha-question">4 + 6</span> = ?  <span onclick="generateCaptcha()">Refresh</span></label>
                        <input type="text" id="captcha-answer" class="form-control" placeholder="Enter your answer">
                     </div>
                     <button type="submit">Submit</button>
                  </div>
                  <div class="col-lg-12 contact-form-msg">
                     <span class="loading"></span>
                  </div>
                  <p>By contacting us, you agree to our <a href="#">Terms of service</a> and <a href="#">Privacy Policy</a></p>
               </form>
            </div>
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
               <a href="#" class="action-filled">Start for free</a>
               <a href="#" class="action-outline">Contact Us</a>
            </div>
         </div>
         <div class="join-right">
            <img src="{{ asset('qr-app/images/join.svg')}}">
         </div>
      </div>
   </div>
</section>

<!-- JavaScript Validation & Captcha -->
<script>
   $(document).ready(function () {
       // Bind submit event to the form
       $(document).on("submit", "#contact-form", function (event) {
           event.preventDefault(); // Prevent default form submission

           if (!validateForm()) {
               return false; // Stop execution if validation fails
           }
           let formData = new FormData(document.getElementById('contact-form'));

           $.ajax({
               url: '{{ route("contact.submit") }}', // Fetch route from data attribute
               type: "POST",
               data: formData,
               dataType: "json",
               contentType: false,
               processData: false,
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               beforeSend: function () {
                   $(".loading").text("Sending...");
               },
               success: function (response) {
                   if (response.success) {
                       toastr.success(response.message);
                       $(".contact-form")[0].reset(); // Reset form fields
                       generateCaptcha(); // Regenerate captcha
                   } else {
                       toastr.error(response.message);
                   }
               },
               error: function () {
                   toastr.error("An error occurred. Please try again later.");
               },
               complete: function () {
                   $(".loading").text("");
               }
           });
       });

       // Function to validate form fields
       function validateForm() {
           let isValid = true;

           let name = $("#name").val().trim();
           let email = $("#email").val().trim();
           let message = $("#message").val().trim();
           let captchaAnswer = $("#captcha-answer").val().trim();
           let expectedAnswer = $("#captcha-question").data("answer");

           // Toastr settings
           toastr.options = {
               closeButton: true,
               progressBar: true,
               positionClass: "toast-top-right",
               timeOut: 3000
           };

           // Clear previous error messages
           toastr.clear();

           if (name === "") {
               toastr.error("Name is required");
               isValid = false;
           }

           if (email === "") {
               toastr.error("Email is required");
               isValid = false;
           } else if (!/^\S+@\S+\.\S+$/.test(email)) {
               toastr.error("Invalid email format");
               isValid = false;
           }

           if (message === "") {
               toastr.error("Message is required");
               isValid = false;
           }

           if (captchaAnswer === "") {
               toastr.error("Please solve the captcha");
               isValid = false;
           } else if (parseInt(captchaAnswer) !== parseInt(expectedAnswer)) {
               toastr.error("Incorrect answer, try again");
               isValid = false;
               generateCaptcha();
           }

           return isValid;
       }


       // Generate a captcha on page load
       generateCaptcha();
   });
   
    // Function to generate a new captcha
    function generateCaptcha() {
        let num1 = Math.floor(Math.random() * 10);
        let num2 = Math.floor(Math.random() * 10);
        let sum = num1 + num2;

        $("#captcha-question").text(`${num1} + ${num2}`);
        $("#captcha-question").data("answer", sum);
        $("#captcha-answer").val(""); // Clear previous answer
    }
</script>
@endsection