@extends('layouts.frondEndApp')
@php
    $status = ''
@endphp
    @if($Parameter['url_type'] == 'change_name') <?php $status = 'name' ?> @endif
    @if($Parameter['url_type'] == 'change_email') <?php $status = 'email' ?> @endif
    @if($Parameter['url_type'] == 'change_phone') <?php $status = 'phone' ?> @endif
    @if($Parameter['url_type'] == 'change_password') <?php $status = 'password' ?> @endif

@section('title-section')
Change {{ $status }} | {{ @config('constants.site_name') }}
@endsection
@section('content')
<div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
                <li class="breadcrumb-item"><a href="{{ url('login-and-security') }}">Login & Security</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change {{ $status }}</li>
            </ol>
        </nav>
        @if (isset($error))
             <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">ERROR!</h4>
                <p>{{ $error }}!</p>
             </div>
        @endif
        @if ($Parameter['url_type'] == 'change_name')
            <div class="heading">
            <h2>Change Your Name</h2>
            <div class="addresses_form">
                <div class="card">
                    <form action="{{ route('update.usercredential') }}" onsubmit="return validation()" method="post">
                        @csrf
                        <div class="add_new_section">
                            <p>If you want to change the name associated with your UEE account, you may do so below. Be
                                sure to click the Save Changes button when you are done.</p>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" id="name" placeholder="Name"
                                        required>
                                </div>
                                <div class="error alert alert-warning" role="alert">
                                   Name must be a string
                                </div>
                                <button class="btn btn-primary">Save Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        
        @if ($Parameter['url_type'] == 'change_email')
            <div class="heading">
            <h2>Change your email address</h2>
            <div class="addresses_form">
                <div class="card">
                    <form action="{{ route('update.usercredential') }}" onsubmit="return validation()" method="post">
                        @csrf
                        <div class="add_new_section">
                            <p>Current email address: vickysharma.m82@gmail.com</p>
                            <p>Enter the new email address you would like to associate with your account below. We will
                                send a One Time Password (OTP) to that address.</p>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" id="email" placeholder="Email"
                                        required>
                                </div>
                                @error('email')
                                  <div class="alert alert-warning" role="alert">
                                      {{ $message }}
                                  </div>
                                @enderror
                                <button class="btn btn-primary">Save Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif



        @if ($Parameter['url_type'] == 'change_phone')
            <div class="heading">
            <h2>Change Mobile Number</h2>
            <div class="addresses_form">
                <div class="card">
                    <form action="{{ route('update.usercredential') }}" onsubmit="return validation()" method="post">
                        @csrf
                        <div class="add_new_section">
                            <p>Old mobile number: 7700871679</p>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="mobile">Phone Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="mobile" id="mobile" value="{{ Auth::user()->phone }}" placeholder="mobile" required>
                                </div>
                                @error('mobile')
                                  <div class="alert alert-warning" role="alert">
                                      {{ $message }}
                                  </div>
                                @enderror
                                <div class="error alert alert-warning" role="alert">
                                   Number can't less or more then 10 digits
                                </div>
                                <button class="btn btn-primary">Save Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        
     @if ($Parameter['url_type'] == 'change_password')
         <div class="heading">
            <h2>Change Password</h2>
            <div class="addresses_form">
                <div class="card">
                    <form action="{{ route('update.usercredential') }}" onsubmit="return validation()" method="post">
                        @csrf
                        <div class="add_new_section">
                            <p>Use the form below to change the password for your UEE account</p>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="old_password">Old Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="old_password" id="old_password"
                                        placeholder="Old password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="new_password"
                                        placeholder="New password" autocomplete="off" required>
                                    </div>
                                    <div class="error alert alert-warning" role="alert">
                                        Please choose a stronger password. Try a mix of letters, numbers and symbols.
                                    </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm new password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        id="confirm_password" placeholder="Confirm password" autocomplete="off" required>
                                </div>
                                 <div class="error alert alert-warning" role="alert">
                                    Those passwords didn’t match. Try again.
                                 </div>
                                <button class="btn btn-primary">Save Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     @endif

        
    </div>
@endsection