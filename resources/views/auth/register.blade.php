@extends('layouts.frondEndApp')
@section('title-section')
Register | {{  @config('constants.site_name') }}
@endsection
@section('content')
            <div class="container mb-5">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="container">
                            <div class="justify-content-center">
                                <div class="">
                                    <div class="card">
                                        <div class="card-header text-center"><h1>Sign Up</h1></div>

                                        <div class="card-body">
                                            <form method="POST" onsubmit="return validation();" action="{{ route('register') }}">
                                                @csrf

                                                <div class="form-group">
                                                    <div class="">
                                                        <label for="name" class="">{{ __('Name') }}</label>
                                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                                    <div >
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone" class="">{{ __('Phone') }}</label>

                                                    <div class="">
                                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="new_password" class="">{{ __('Password') }}</label>

                                                    <div class="">
                                                        <input id="new_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="error alert alert-warning" role="alert">
                                                        Please choose a stronger password. Try a mix of letters, numbers and symbols.
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="confirm_password" class="">{{ __('Confirm Password') }}</label>

                                                    <div class="">
                                                        <input id="confirm_password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                    </div>
                                                </div>
                                                <div class="error alert alert-warning" role="alert">
                                                    Those passwords didn’t match. Try again.
                                                </div>
                                                <div class="form-group mb-0">
                                                    <div class="">
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            {{ __('Register') }}
                                                        </button>
                                                    </div>
                                                    <div class="mt-2">
                                                        <h5>Already have account? <a href="{{ route('login') }}">Sign In</a></h5>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
