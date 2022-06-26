@extends('layouts.frondEndApp')
@section('title-section')
Login | {{  @config('constants.site_name') }}
@endsection
@section('content')
    <div class="container mb-5">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="container">
                            <div class="justify-content-center">
                                <div class="">
                                    <div class="card">
                                        <div class="card-header text-center"><h1>Login</h1></div>

                                        <div class="card-body">
                                            <form action="{{ route('login') }}" method="post">
                                                @csrf

                                                <div class="form-group">
                                                    <div class="">
                                                        <label for="name" class="">{{ __('Email Address') }}</label>
                                                        <input id="name" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email Address" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="">
                                                        <label for="pass" class="">{{ __('Password') }}</label>
                                                        <input id="pass" class="form-control" type="password" name="password" placeholder="Password" required>
                                                    </div>
                                                </div>

                                               <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-check-label" for="defaultCheck1">Remember Me</label>
                                                        @if (Route::has('password.request'))
                                                             <a href="{{ route('password.request') }}">Forgot Password?</a>
                                                        @endif
                                                    </div>
                                               </div>
                                                @if ($message = Session::get('error'))
                                                    <div class="alert alert-warning" role="alert">
                                                       {{ $message }}
                                                    </div>
                                                @endif
                                              <button class="btn btn-primary btn-block my-4" type="submit">sign in</button>
                                            </form>
                                            <div class="register-link">
                                                <p>
                                                    Don't you have account?
                                                    <a href="{{ route('register') }}">Sign Up Here</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection