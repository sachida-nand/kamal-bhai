@extends('layouts.frondEndApp')
@section('title-section')
Add Your Address | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="container">
        <div class="heading mt-3">
           <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('your-account') }}">Your Account</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('your-address') }}">Your Address</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add new address</li>
                </ol>
            </nav>
        </div>
            <div class="addresses_form">
               <div class="card">
                <form action="{{ route('add.address') }}" method="post">
                    @csrf
                    <input type="hidden" name="address_id" value="{{ $Address != null ? $Address->id : '' }}">
                    <div class="add_new_section">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $Address != null ? $Address->full_name : '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="mobile" id="mobile" placeholder="10-digit mobile number" value="{{ $Address != null ? $Address->mobile : '' }}" required>
                                </div>
                    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="pincode">Pin/Zip code</label>
                                    <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="{{ $Address != null ? $Address->pincode : '' }}" id="pincode">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="city">City/Town <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ $Address != null ? $Address->city : '' }}" placeholder="City/Town" required>
                                </div>
                            </div>
                        </div>
                        <div class="address">
                            <div class="form-group">
                                <label for="flate">Flate/House No./Building/Comapany/Apartment <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address_one" id="flate" value="{{ $Address != null ? $Address->address_one : '' }}" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="address_two">
                            <div class="form-group">
                                <label for="area">Area/Colony/Sector/Village</label>
                                <input type="text" class="form-control" name="address_two" id="area" value="{{ $Address != null ? $Address->address_two : '' }}" value="{{ $Address != null ? $Address->address_two : '' }}" placeholder="Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" class="form-control" name="landmark" id="landmark" value="{{ $Address != null ? $Address->landmark : '' }}" placeholder="E.g. Near Ghati Chock">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="district" placeholder="District" id="district" 
                                value="{{ $Address != null ? $Address->district : '' }}"  required>
                            </div>
                        </div>
                        <p class="mb-2">Address Type <span class="text-danger">*</span></p>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-check">
                                    <input type="radio" name="address_type" id="home" value="HOME" {{ $Address != null && $Address->address_type =='HOME' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="home">
                                        Home (Delivery between 7 AM - 9 PM)
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-check">
                                    <input type="radio" name="address_type" id="work" value="WORK" {{ $Address != null && $Address->address_type =='WORK' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="work">
                                        Work (Delivery between 10 AM - 5 PM)
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3 ml-2">
                                <button class="btn btn-warning">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
               </div>
            </div>
    </div>
@endsection