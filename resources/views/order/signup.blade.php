@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Sign up')
@section('page-id', 'signup')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <span class="badge text-bg-primary-subtle text-primary mb-2">Join the club</span>
        <h1 class="fw-bold mb-2">Create your account</h1>
        <p class="text-secondary mb-0">Save your favourites, track orders, and unlock exclusive rewards.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <form class="d-grid gap-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">First name</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="First name">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Last name</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="Last name">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control form-control-lg" placeholder="you@example.com">
                            </div>
                            <div>
                                <label class="form-label">Mobile number</label>
                                <input type="tel" class="form-control form-control-lg" placeholder="Contact number">
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control form-control-lg" placeholder="********">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Confirm password</label>
                                    <input type="password" class="form-control form-control-lg" placeholder="********">
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="terms">
                                <label class="form-check-label" for="terms">I agree to the <a href="#">Terms & Conditions</a>.</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Create account</button>
                            <div class="text-center text-secondary small">Already have an account? <a href="{{ route('order.login', ['code' => $vendor->code]) }}">Sign in</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
