@extends('layouts.main')
@section('content')
    <div class="container">
        <section class="space-top space-extra-bottom d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: #8c00ff;">
                                <h6 style="color: white;">Edit Profile</h6>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('user.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>

                                    <!-- Add other profile fields here -->

                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>

                                <hr>

                                <h5 class="mt-4">Change Password</h5>
                                <form method="POST" action="{{ route('user.password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email" required autofocus
                                            class="form-control" value="{{ $user->email }}" >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
