@extends('layouts.frondEndApp')
@section('title-section')
Write Revire | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="container">
        <div class="heading">
            <h2>Create review</h2>
            <div class="card">
                    <div class="order_details_section">
                    <div class="ship_product_details">
                        <div class="ship_product_item">
                            <div class="row">
                                <div class="col-2">
                                    <div class="pl-2 ship_img">
                                        <img src="1.jpg" alt="" width="50">
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="col-10">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    </div>
                                    <!-- Lorem, ipsum dolor sit amet consectetur adipisicing elit. -->
                                </div>
                            </div>
                            <hr>
                            <form action="" method="get">

                                <div class="star">
                                <h5>Overall rating</h5>
                                <div class="rating-icon">
                                    <input type="radio" name="star" id="star-5" value="5">
                                    <label for="star-5"></label>
                                    <input type="radio" name="star" id="star-4" value="4">
                                    <label for="star-4"></label>
                                    <input type="radio" name="star" id="star-3" value="3">
                                    <label for="star-3"></label>
                                    <input type="radio" name="star" id="star-2" value="2">
                                    <label for="star-2"></label>
                                    <input type="radio" name="star" id="star-1" value="1">
                                    <label for="star-1"></label>
                                </div>
                            </div><hr>
                            <h5>Add a headline</h5>
                            <div class="form-group">
                                <input type="text" class="form-control" name="heading" placeholder="What's most important to know?" required>
                            </div>
                            <h5>Add a written review</h5>
                            <div class="form-group">
                                <textarea class="form-control" name="review" id="" rows="3" placeholder="What did you like or dislike? What did you use this product for?"></textarea>
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