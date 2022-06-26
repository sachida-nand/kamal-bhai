@extends('layouts.frondEndApp')
@section('meta_desc'){{ $Product->meta_description }}@endsection
@section('meta_tag'){{ $Product->tags }}@endsection
@section('title-section')
{{ $Product->product_name.' | '.@config('constants.site_name') }}
@endsection
@section('content')
 @php
    $ProductImages = $Product->images;
    if ($ProductImages != '') {
        $ProductImageArray = explode(',', $ProductImages);
    }
@endphp
<script>
    var stock = {{ $Product->quantity }}
    var minpurchageqty = {{ $Product->minimum_purchage_qty }}
</script>
<div class="">
        <div class="details_gallery card">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="gallery">
                        <div class="main_img">
                            <img src="{{ asset('storage/product_images/'.$ProductImageArray[0]) }}" id="main-img" alt="">
                        </div>
                        <div class="gallery_img">
                            <div class="swiper galler-imgg">
                                <div class="swiper-wrapper">
                                    @foreach ($ProductImageArray as $image)
                                       <div class="swiper-slide">
                                          <img class="" src="{{ asset('storage/product_images/'.$image) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="details">
                        <div class="product_name">
                            <h1>{{ $Product->product_name }}</h1>
                        </div>
                        <div class="revie">
                            <i class="fas fa-star rated"></i>
                            <i class="fas fa-star rated"></i>
                            <i class="fas fa-star rated"></i>
                            <i class="fas fa-star not-rated"></i>
                            <i class="fas fa-star not-rated"></i>
                            <span>
                                <b> (No reviews)</b>
                            </span>
                        </div>
                        <div class="details_price">
                            <p>
                                @if ($Product->discount == '')
                                   <span class="selling_price">&#8377; <span class="selling_pricee">
                                    {{ $Product->unit_price }}.00</span></span>
                                @else
                                <span class="selling_price">&#8377; <span class="selling_pricee">
                                    {{ $Product->discounted_price }}.00</span></span>
                                <span class="market_price">&#8377; {{ $Product->unit_price }}.00</span>
                                <span class="discount_amount">(
                                    @if($Product->discount_type == 'flat') &#8377;&nbsp; @endif
                                      {{ $Product->discount }}
                                    @if ($Product->discount_type == 'percentage')%@endif
                                    OFF)
                                </span>
                                @endif
                                
                            </p>
                        </div>
                        <div class="available">
                            <p>
                            <b>Availability:</b> 
                                <span>
                                    @if ($Product->quantity <=0)
                                        Out Of stock
                                    @elseif ($Product->quantity > $Product->stock_warnning)
                                        In stock
                                    @else
                                    Hurry Up! Only {{ $Product->quantity }} items Left
                                    @endif
                                    {{-- In stock --}}
                                </span>
                            </p>
                        </div>
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                     @if ($Product->quantity > 0)
                        <div class="Quantity">
                               <div class="quantity_input">
                                    <p><b>Quantity</b></p>
                                    <span class="decrease">-</span> <input type="number" name='qty' value="1"
                                        class="quenty_value" /><span class="increase">
                                    +</span>
                                </div> 
                           
                            <div class="sub_total">
                                <p><b>Sub total</b></p>
                                <p id="sub_total">&#8377; <span id="sub_total_value"></span></p>
                                <!-- <input type="text" id="sub_total" readonly value="1900000.00"> -->
                            </div>
                        </div>
                        <div class="error alert-warning" role="alert">
                           
                        </div>
                        <div class="add_to_card_buy_now">
                            <div class="add_to_cart">
                                <a id="{{ $Product->id }}" items="details"><i class="fas fa-cart-plus"></i> <span>Add to Cart</span></a>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $Product->id }}">
                            <input type="hidden" name="from_details_page" value="fromDetailsPage">
                            <div class="buy_now">
                                <button><i class="fas fa-shopping-bag"></i> Buy Now</button>
                            </div>
                        </div>
                     @endif
                     </form>
                        <div class="social_media">
                            <b>Share: </b>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                            <a href="#"><i class="fab fa-twitter-square"></i></a>
                            <a href="#"><i class="fab fa-facebook-square text-primary"></i></a>
                            <a href="#"><i class="fab fa-whatsapp-square text-success"></i></a>
                        </div>
                        <div class="short_desc">
                            <ul>
                                <li><b>Cash On Delivery (COD):</b> <span>
                                    {{ $Product->cash_on_delivery == 'yes' ? "Available" : "Not Available" }}</span></li>
                                <li><b>Shiping Charge:</b> <span>
                                    {{ $Product->free_shipping == 'yes' ? 'Free' :'₹ '. $Product->shipping_cost.'.00'}}</span></li>
                                <li><b>Replacement: </b><span> 10 Days Replacement</span></li>
                                <li><b>Expected delivery: </b><span> {{ now()->addDays($Product->est_shipping_time)->format('D, j M Y') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3 details_section">
        <div class="description_heading" id="tabs">
            <h5 class="desclinks item_links active" onclick="showHide('long_description','desclinks')"><a id="tab" href="javascript:void(0);">Description</a></h5>
            <h5 class="videolinks item_links" onclick="showHide('video','videolinks')"><a href="javascript:void(0);">Video</a></h5>
            <h5 class="reviewlinks item_links" onclick="showHide('rating_reviews','reviewlinks')"><a href="javascript:void();">Review</a></h5>
        </div>
        
        <div class="content">
            <div class="long_description tab-items active" id="longdescription">
               {!! $Product->product_description !!}
            </div>
            <div class="video text-center tab-items">
                @if($Product->video_link != '')
                  {!! $Product->video_link !!}
                @else
                    <h3>Video not Available on this Product</h3>
                @endif
                {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/7zEx0AJguSM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
            </div>

           <div class="rating_reviews tab-items">
            @if (!$Product->Review->isEmpty())
                @foreach ($Product->Review as $Review)
                 <div class="reviews mb-2">
                    <div class="customer_img">
                        <img src="{{ asset('storage/userprofile/'.$Review->UserDetails->image) }}" alt="customer" />
                    </div>
                    <div class="message">
                        <h4>{{ $Review->UserDetails->name }}</h4>
                        <small>{{ date_format($Review->created_at,'d/m/Y') }}</small>
                        <div class="rating mb-2">
                            @for ($i=1; $i<=5; $i++)
                                @if($i <= $Review->star)
                                    <i class="fas fa-star rated"></i>
                                @else
                                   <i class="fas fa-star not-rated"></i>
                                @endif
                            @endfor
                        </div>
                        <h5>{{ $Review->heading }}</h5>
                        <p>{{ $Review->description }}</p>
                    </div>
                 </div>
                @endforeach
            @else 
              <h5>No Review yet!</h5>
            @endif
               
           </div>  
        </div>
    </div>
@endsection
@section('script')
<script>
        var swiper = new Swiper(".galler-imgg", {
            slidesPerView: 5,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                "@0.00": {
                    slidesPerView: 4,
                    spaceBetween: 10,
                    slidesPerGroup: 1,
                },
                "@0.75": {
                    slidesPerView: 5,
                    slidesPerGroup: 2,
                },
                "@1.50": {
                    slidesPerView: 5,
                    slidesPerGroup: 3,
                },
                // "@2": {
                //     slidesPerView: 5,
                //     slidesPerGroup: 5,
                // },
            },
        });

        $(document).ready(function () {
            $('.gallery_img img').hover(function () {
                var image = $(this).attr('src');
                $('.main_img img').attr('src', image);
                if ($('.gallery_img img').hasClass('active')) {
                    $('.gallery_img img').removeClass('active')
                }
                $(this).addClass('active')
            });
            if ($(document).innerWidth() > 786) {
                $("#main-img").imagezoomsl({
                    zoomrange: [3, 3],
                });
            }
        });
    </script>
@endsection