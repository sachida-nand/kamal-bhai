@extends('layouts.frondEndApp')
@section('title-section')
Write review | {{ @config('constants.site_name') }}
@endsection
@section('content')
<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
            <li class="breadcrumb-item"><a href="{{ url('product-review') }}">Your Review</a></li>
            <li class="breadcrumb-item active" aria-current="page">Write product review</li>
        </ol>
    </nav>
    <div class="heading">
        <h2>Create review</h2>
        <div class="card">
                <div class="order_details_section">
                <div class="ship_product_details">
                    <div class="ship_product_item">
                        <div class="row">
                            <div class="col-2">
                                <div class="pl-2 ship_img">
                                    <img src="{{ asset('storage/product_images/'.$Product->PImage->image) }}" alt="" width="50">
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="col-10">
                                   <p>{{ $Product->product_name }}</p>
                                </div>
                                <!-- Lorem, ipsum dolor sit amet consectetur adipisicing elit. -->
                            </div>
                        </div>
                        <hr>
                        <form action="{{ route('manage.review') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $Product->id }}">
                            <input type="hidden" name="order_id" value="{{ $Order->order_id }}">
                            <input type="hidden" name="review_id" value="{{ $Review != null ? $Review->id : 0 }}">
                            <div class="star">
                            <h5>Overall rating</h5>
                            <div class="rating-icon">
                                <input type="radio" name="star" id="star-5" {{ $Review != null && $Review->star ==5 ? 'checked' : '' }} value="5">
                                <label for="star-5"></label>
                                <input type="radio" name="star" id="star-4" {{ $Review != null && $Review->star ==4 ? 'checked' : '' }} value="4">
                                <label for="star-4"></label>
                                <input type="radio" name="star" id="star-3" {{ $Review != null && $Review->star ==3 ? 'checked' : '' }} value="3">
                                <label for="star-3"></label>
                                <input type="radio" name="star" id="star-2" {{ $Review != null && $Review->star ==2 ? 'checked' : '' }} value="2">
                                <label for="star-2"></label>
                                <input type="radio" name="star" id="star-1" {{ $Review != null && $Review->star ==1 ? 'checked' : '' }} value="1">
                                <label for="star-1"></label>
                            </div>
                        </div><hr>
                        <h5>Add a headline</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" name="heading" placeholder="What's most important to know?" value="{{ $Review != null ? $Review->heading : '' }}" required>
                        </div>
                        <h5>Add a written review</h5>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="" rows="3" placeholder="What did you like or dislike? What did you use this product for?">{{ $Review != null ? $Review->description : '' }}</textarea>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-outline-warning text-dark">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection