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
                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <form method="POST" action="{{ route('user.password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email" required autofocus
                                            class="form-control">
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
