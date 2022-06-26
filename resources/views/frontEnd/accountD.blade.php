@extends('layouts.frondEndApp')
@section('title-section')
Your Account | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="container">
        <div class="heading mt-3">
            <h2>Account</h2>
            <div class="account_section">
                <div class="account-row">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <a href="{{ url('order-history') }}">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-order.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Your Orders</h5>
                                            <p class="Small_text">Track, return, or buy things again</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a href="{{ url('login-and-security') }}">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-login.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Login & security</h5>
                                            <p class="Small_text">Edit login, name, photo, and mobile number</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a href="{{ url('your-address') }}">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-address.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Your Addresses</h5>
                                            <p class="Small_text">Edit addresses for orders</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="account-row">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <a href="{{ url('product-review') }}">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-review.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Product review</h5>
                                            <p class="Small_text">See, Edit or delete product review</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a href="">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-replace.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Your returns</h5>
                                            <p class="Small_text">Return and replace product details</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a href="{{ url('support-ticket') }}">
                                <div class="card">
                                    <div class="content d-flex">
                                        <div class="icon"><img src="{{ asset('media/icons-support.png') }}" alt=""></div>
                                        <div class="text">
                                            <h5 class="headers">Support ticket</h5>
                                            <p class="Small_text">Create, view problem tickets, and contact our executives</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection