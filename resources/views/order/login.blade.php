@extends('order.layouts.app')

@section('title', (optional($settings)->store_name ?? $vendor->name) . ' – Login')
@section('page-id', 'login')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <span class="badge text-bg-primary-subtle text-primary mb-2">Welcome back</span>
        <h1 class="fw-bold mb-2">Sign in to continue</h1>
        <p class="text-secondary mb-0">Access saved preferences, reorder favourites, and track your history.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <form class="d-grid gap-3">
                            <div>
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control form-control-lg" placeholder="you@example.com">
                            </div>
                            <div>
                                <label class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-lg" placeholder="********">
                                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="#" class="small">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Sign in</button>
                            <div class="text-center text-secondary small">Don't have an account? <a href="{{ route('order.signup', ['code' => $vendor->code]) }}">Create one</a></div>
                            <div class="text-center">
                                <span class="text-secondary small">Or continue with</span>
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-google me-1"></i>Google</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-apple me-1"></i>Apple</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
