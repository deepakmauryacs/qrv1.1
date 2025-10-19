<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin Login</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
      <link href="{{ asset('onboarding/css/custom.css')}}" rel="stylesheet">
       <style>
        .captcha-box {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .captcha-box span {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
        .refresh-btn {
            border: none  !important;
            cursor: pointer  !important;
            font-size: 18px  !important;
            color: #007bff  !important;
            height: 40px  !important;
            width: 120px  !important;
            border-radius: 15px  !important;
        }
    </style>
   </head>
   <body>
      <figure class="logo">
         <img src="https://www.digitalqr.in/web-app/images/logo-blue-white.png">
      </figure>
      <div class="loginContainer">
         <div class="login-left">
            <figure>
               <img src="https://www.digitalqr.in/login/images/login-bg.webp" style="border-radius: 5px 0px 0px 5px;">
            </figure>
         </div>
         <div class="login-right">
            <h2>Welcome Back !</h2>
             <form class="user" method="POST" action="{{ route('vendor.login.submit') }}">
               @csrf
               <div class="login-section">
                  <div class="form-group">
                     <label>Email ID</label>
                     <input type="email" class="form-control form-control-user" name="email" placeholder="Enter Email Address...">
                  </div>
                  <div class="form-group position-relative">
                     <label>Password</label>
                     <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                     <span class="position-absolute" style="right: 15px; top: 69%; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword()">
                                            <i id="toggleIcon" class="fas fa-eye"></i>
                                        </span>
                  </div>

                   <!-- Dynamic Math Captcha with Refresh Button -->
                    <div class="form-group captcha-box">
                        <span id="captchaQuestion">5 + 4 = </span>
                        <input type="text" class="form-control form-control-user" id="captchaInput" placeholder="Enter answer">
                        <!--<button type="button" class="refresh-btn" onclick="generateCaptcha()">-->
                        <!--    <i class="fas fa-sync-alt"></i>-->
                        <!--</button>-->
                    </div>


                  <div class="form-group checkboxLogin"> 
                     <input type="checkbox" class="custom-control-input" id="customCheck">
                     <label class="custom-control-label" for="customCheck">Remember Me</label>
                  </div>
                  <div class="form-group">  
                     <button>Login</button>
                  </div>
               </div>
               <a href="https://www.digitalqr.in" class="backToPage"> Back to Main</a>
            </form>
         </div>
      </div>
   </body>
   <script src="{{ asset('onboarding/dist/lib/jQuery/jquery-3.7.1.min.js')}}"></script>
   <script>
        let correctAnswer = 9; // Default correct answer

        function generateCaptcha() {
            let num1 = Math.floor(Math.random() * 10) + 1;
            let num2 = Math.floor(Math.random() * 10) + 1;
            correctAnswer = num1 + num2;
            document.getElementById("captchaQuestion").textContent = `${num1} + ${num2} = `;
            document.getElementById("captchaInput").value = ""; // Clear input field
        }

        // function validateCaptcha() {
        //     let captchaAnswer = document.getElementById("captchaInput").value;
        //     if (parseInt(captchaAnswer) !== correctAnswer) {
        //         alert("Captcha incorrect! Please enter the correct answer.");
        //         return false;
        //     }
        //     return true;
        // }

        function togglePassword() {
            let passwordInput = document.getElementById("password");
            let toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        // Generate a random CAPTCHA on page load
        window.onload = generateCaptcha;

        document.addEventListener("DOMContentLoaded", function () {
	    document.querySelector(".user").addEventListener("submit", function (event) {
	        let email = document.querySelector("input[name='email']");
	        let password = document.querySelector("input[name='password']");
	        let captchaInput = document.getElementById("captchaInput");
	        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	        let valid = true;

	        document.querySelectorAll(".error-message").forEach(el => el.textContent = "");

	        if (email.value.trim() === "") {
	            email.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Email is required.</span>');
	            valid = false;
	        } else if (!emailPattern.test(email.value.trim())) {
	            email.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Please enter a valid email address.</span>');
	            valid = false;
	        }

	        if (password.value.trim() === "") {
	            password.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Password is required.</span>');
	            valid = false;
	        } else if (password.value.trim().length < 6) {
	            password.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Password must be at least 6 characters long.</span>');
	            valid = false;
	        }

	        if (captchaInput.value.trim() === "") {
	            captchaInput.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Captcha is required.</span>');
	            valid = false;
	        } else if (parseInt(captchaInput.value.trim()) !== correctAnswer) {
	            captchaInput.insertAdjacentHTML('afterend', '<span class="error-message text-danger">Captcha incorrect! Please enter the correct answer.</span>');
	            valid = false;
	        }

	        if (!valid) {
	            event.preventDefault();
	        }
	    });

	    document.getElementById("captchaInput").addEventListener("keypress", function (event) {
	        if (!/\d/.test(event.key)) {
	            event.preventDefault();
	        }
	    });
	});

    </script>
</html>