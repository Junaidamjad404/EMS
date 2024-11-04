@extends('layouts.main')
@section('content')
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="auth-style">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-tab-pane" type="button" role="tab"
                                    aria-controls="profile-tab-pane" aria-selected="false">Register</button>
                            </li>
                        </ul>
                        <div class="auth-social">
                            <h5 class="auth-title">Log In Directly With</h5>
                            <div class="footer-social style3">
                                <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{ url('auth/google') }}"><i class="fab fa-google"></i></a>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <form class="auth-form" method="POST" action="{{ route('user.store.login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="auth-label" for="email">{{ __('Email') }}</label>
                                        <input id="email" type="email" name="email" placeholder="Email"
                                            class="form-control" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="auth-label" for="password">{{ __('Password') }}</label>
                                        <input id="password" type="password" name="password" placeholder="Password"
                                            class="form-control" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="vs-btn w-100">
                                            Log In
                                        </button>
                                    </div>
                                    <!-- Forgot Password Link -->
                                    <p class="auth-link">
                                        <a href="{{ route('user.password.request') }}">Forgot Password?</a>
                                    </p>
                                    <p class="auth-link">Not A Member? <a href="{{ route('user.register') }}">Register</a>
                                    </p>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                                tabindex="0">
                                <form class="auth-form" method="POST" action="{{ route('user.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="auth-label" for="name">Name</label>
                                        <input type="text" name="name" placeholder="Name" class="form-control"
                                            required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="auth-label" for="email">Email</label>
                                        <input type="email" name="email" placeholder="Email" class="form-control"
                                            required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="auth-label" for="password">Password</label>
                                        <input type="password" name="password" placeholder="Password"
                                            class="form-control" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="auth-label" for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation"
                                            placeholder="Confirm Password" class="form-control" required>
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="vs-btn w-100">
                                            Register
                                        </button>
                                    </div>

                                    @if (session('error'))
                                        <div class="alert alert-danger mt-3">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

