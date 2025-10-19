@extends('default') 
@section('title', 'Terms & Conditions - Digital QR')
@section('content')
<style>
    .terms-para {
        font-size: 18px !important;
        color: #fffff8 !important;
    }
    .fullPara h2 {
        color: #fffff8 !important;
        font-size: 20px !important;
        font-weight: bold !important;
    }
    .fullPara p {
        margin-bottom: 20px !important;;
    }
    .fullPara ul li strong {
        color: #fffff8 !important;
    }
</style>
<section class="herobannersect">
    <div class="container">
        <div class="herob-wrap">
            <h1>Terms & Conditions</h1>
        </div>
    </div>
</section>
<section class="screens-sect digitalMenu">
    <div class="container">
        <div class="col-md-12">
            <p class="terms-para">
                Welcome to <strong>Digital QR</strong>! These Terms and Conditions outline the rules and regulations for the use of our platform, operated by <strong>AETHERGRID INNOVATECH PRIVATE LIMITED</strong>.
            </p>
            <p class="terms-para">
                By accessing and using our services at <a href="https://www.digitalqr.in" target="_blank">https://www.digitalqr.in</a>, you agree to accept all terms and conditions stated here. Please do not continue to use Digital QR if you do not agree to all the Terms and Conditions.
            </p>
        </div> 

        <div class="fullPara">
            <h2>1. Acceptance of Terms</h2>
            <p class="terms-para">By using Digital QR, you agree to be legally bound by these Terms. We may update these Terms at any time, and your continued use after any changes signifies your acceptance of the new Terms.</p>

            <h2>2. Eligibility</h2>
            <p class="terms-para">Our services are intended for users who are at least 13 years old. By using Digital QR, you represent and warrant that you meet this requirement.</p>

            <h2>3. Services</h2>
            <p class="terms-para">Digital QR offers a Digital Menu Management System, including QR Code Generation, Real-Time Updates, and Customer Analytics to improve your business operations.</p>

            <h2>4. Account Registration</h2>
            <p class="terms-para">You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</p>

            <h2>5. Subscription & Payment</h2>
            <p class="terms-para">Our services operate on a subscription model with a recurring fee of ₹99 per month. Payments are processed via UPI, debit/credit cards, net banking, and other supported methods.</p>

            <h2>6. Automatic Renewal & Cancellation</h2>
            <p class="terms-para">Subscriptions automatically renew unless canceled before the next billing cycle. Upon cancellation, access to premium features ends after the current billing period.</p>

            <h2>7. Intellectual Property Rights</h2>
            <p class="terms-para">All trademarks, logos, and software related to Digital QR are owned by AETHERGRID INNOVATECH PRIVATE LIMITED. Unauthorized use is prohibited.</p>

            <h2>8. User Conduct & Prohibited Activities</h2>
            <p class="terms-para">You agree not to misuse the platform, disrupt its functionality, or attempt unauthorized access or source code extraction.</p>

            <h2>9. Disclaimer of Warranties</h2>
            <p class="terms-para">Our services are provided "as is" without warranties of any kind. We do not guarantee uninterrupted service or error-free functionality.</p>

            <h2>10. Limitation of Liability</h2>
            <p class="terms-para">We are not liable for any direct, indirect, incidental, or consequential damages arising from the use of our platform.</p>

            <h2>11. Termination</h2>
            <p class="terms-para">We reserve the right to suspend or terminate accounts that violate these Terms or misuse our services.</p>

            <h2>12. Governing Law & Disputes</h2>
            <p class="terms-para">These Terms are governed by the laws of India. Any disputes will be resolved under the exclusive jurisdiction of courts in Varanasi, Uttar Pradesh.</p>

            <h2>13. Contact Us</h2> 
            <p class="terms-para">For any questions or concerns regarding these Terms, please reach out to us:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:support@digitalqr.in">support@digitalqr.in</a></li>
                <li><strong>Website:</strong> <a href="https://www.digitalqr.in" target="_blank">www.digitalqr.in</a></li>
            </ul>

            <p><em>Effective Date: February 2025</em></p>
        </div>
    </div>
</section>

<section class="joindigital-sect">
    <div class="container">
        <div class="join-grid">
            <div class="join-left">
                <h2>Ready to Get Started with Digital QR?</h2>
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
