@extends('layouts.main')

@section('content')
    <div class="container">
        <section class="space-top space-extra-bottom d-flex align-items-center justify-content-center"
            style="min-height: 100vh;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: #8c00ff;">
                                <h6 style="color: white;">Reset Password</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email"
                                            value="{{ old('email', $request->email) }}" required autofocus
                                            class="form-control @error('email') is-invalid @enderror">

                                        <!-- Display Email Error -->
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input id="password" type="password" name="password" required
                                            class="form-control @error('password') is-invalid @enderror" autocomplete="off">

                                        <!-- Display Password Error -->
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            required
                                            class="form-control @error('password_confirmation') is-invalid @enderror">

                                        <!-- Display Password Confirmation Error -->
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
