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
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form class="d-grid gap-3" method="POST" action="{{ route('order.signup.submit', ['code' => $vendor->code]) }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="first_name">First name</label>
                                    <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="last_name">Last name</label>
                                    <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="phone">Mobile number</label>
                                <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contact number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" required autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="password_confirmation">Confirm password</label>
                                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="********" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" value="1" id="terms" name="terms" @if(old('terms')) checked @endif>
                                <label class="form-check-label" for="terms">I agree to the <a href="#">Terms & Conditions</a>.</label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
