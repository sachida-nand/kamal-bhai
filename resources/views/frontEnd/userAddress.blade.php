@extends('layouts.frondEndApp')
@section('title-section')
Your Address | {{ @config('constants.site_name') }}
@endsection
@section('content')
<script>
    removeAddress = "{{ route('removeAddressAjax') }}"
</script>
<div class="container">
        <div class="heading mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('your-account') }}">Your Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Your Address</li>
                </ol>
            </nav>
                <div class="error alert alert-success" role="alert">
                    <h4 class="alert-heading">Success</h4>
                    <p>You successfully removed your address.</p>
                </div>
             @if ($message = Session::get('msg'))
                <div class="alert alert-success w-50" role="alert">
                    {{ $message }}
                </div>
             @endif
            <div class="addresses">
                <div class="address-row">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 cc">
                            <a href="{{ url('your-address/add-your-address') }}">
                                <div class="card new_address">
                                    <div class="content">
                                        <div class="icon"><i class="fas fa-plus fa-3x"></i></div>
                                        <div class="text">
                                            <h3 class="headers">Add new address</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach (userAddress() as $address)
                            <div class="col-lg-4 col-sm-12 add">
                            <div class="card mb-3">
                                <div class="content">
                                    <ul>
                                        <li><h5>{{ $address->full_name }}</h5></li>
                                        <li><span>{{ $address->address_one }}</span></li>
                                        <li><span>{{ $address->address_two }}</span></li>
                                        <li><span>{{ $address->landmark }}</span></li>
                                        <li><span>{{ $address->city.', '.$address->district.'- '.$address->pincode }}</span></li>
                                        <li><span>Address type: {{ $address->address_type }}</span></li>
                                        <li><span>phone number: {{ $address->mobile }}</span></li>
                                    </ul>
                                </div>
                                <div class="linkss">
                                    <a href="{{ url('your-address/edit-your-address/'.$address->id) }}">Edit</a> &nbsp; |&nbsp; <a href="#" class="address_remove" address_id="{{ $address->id }}">Remove</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection