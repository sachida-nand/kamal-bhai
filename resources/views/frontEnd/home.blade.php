@extends('layouts.frondEndApp')
@section('title-section','Unique Electric Enterprises')
@section('content')
<div id="crousels" class="carousel slide bannerr" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('media/1.jpg') }}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('media/2.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('media/3.jpg') }}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#crousels" role="button" data-slide="prev">
            <span class="prev-button"><i class="fas fas-cus fa-angle-left fa-3x"></i></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#crousels" role="button" data-slide="next">
            <span class="next-button"><i class="fas fas-cus fa-angle-right fa-3x"></i></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- featured products -->
    @if (!$FeaturedProducts->isEmpty())
        <div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>Featured Product</h3> <a href="{{ url('op/feature-products') }}">See all</a>
                <div class="swiper-pagination"></div>
            </div>

            <div class="card">
                <div class="card_section">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                          @foreach ($FeaturedProducts as $FProduct)
                               <div class="swiper-slide">
                                <div class="card_items">
                                    <a href="{{ url('product/'.$FProduct->slug) }}">
                                        <div class="img">
                                            <img src="{{asset('storage/product_images/'.$FProduct->PImage->image)}}" alt="product image">
                                           
                                                @if ($FProduct->discount != '')
                                                    <div class="discount">
                                                        @if ($FProduct->discount_type == 'flat')&#8377;&nbsp;  @endif
                                                        {{ $FProduct->discount }}
                                                        @if ($FProduct->discount_type == 'percentage')%@endif
                                                        OFF
                                                    </div>
                                                @endif
                                           
                                        </div>
                                        <div class="content">
                                            <div class="price">
                                              @if ($FProduct->discount == '')
                                                <div class="selling_price">
                                                    <p>&#8377; <span>{{ $FProduct->unit_price }}.00</span></p>
                                                </div>
                                              @else
                                                <div class="selling_price">
                                                    <p>&#8377; <span>{{ $FProduct->discounted_price }}.00</span></p>
                                                </div>
                                                 <div class="original_price">
                                                    <p>&#8377; <span>{{ $FProduct->unit_price }}</span></p>
                                                 </div>
                                              @endif
                                            </div>
                                            <div class="rating text-center">
                                                &#11088;&#11088;&#11088;&#11088;&#11088;
                                            </div>
                                            <p class="p_name">{{ $FProduct->product_name }}</p>
                                        </div>
                                    </a>
                                    {{-- <div class="add_to_cart_buy_now">
                                        <div class="add_to_cart">
                                            <a href="#"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                          @endforeach
                                  
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- featured products ends-->
    <!--Deal of the day -->
    @if (!$DealOfTheDays->isEmpty())
         <div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>Deal of the Day</h3>
                <a href="{{ url('op/deal-of-the-day') }}">See all</a>
                <div class="swiper-pagination"></div>
            </div>

            <div class="card">
                <div class="card_section">
                    <div class="swiper mySwiperr">
                        <div class="swiper-wrapper">
                          @foreach ($DealOfTheDays as $DProduct)
                              <div class="swiper-slide">
                                <div class="card_items">
                                    <a href="{{ url('product/'.$DProduct->slug) }}">
                                        <div class="img">
                                            <img src="{{asset('storage/product_images/'.$DProduct->PImage->image)}}" alt="product image">
                                            @if ($DProduct->discount != '')
                                                <div class="discount">
                                                    @if ($DProduct->discount_type == 'flat')&#8377;&nbsp;  @endif
                                                    {{ $DProduct->discount }}
                                                    @if ($DProduct->discount_type == 'percentage')%@endif
                                                    OFF
                                                </div>
                                            @endif
                                        </div>
                                        <div class="content">
                                            <div class="price">
                                                @if ($DProduct->discount == '')
                                                    <div class="selling_price">
                                                        <p>&#8377; <span>{{ $DProduct->unit_price }}.00</span></p>
                                                    </div>
                                                @else
                                                    <div class="selling_price">
                                                        <p>&#8377; <span>{{ $DProduct->discounted_price }}.00</span></p>
                                                    </div>
                                                    <div class="original_price">
                                                        <p>&#8377; <span>{{ $DProduct->unit_price }}</span></p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="rating text-center">
                                                &#11088;&#11088;&#11088;&#11088;&#11088;
                                            </div>
                                            <p class="p_name">{{ $DProduct->product_name }}</p>
                                        </div>
                                    </a>
                                    {{-- <div class="add_to_cart_buy_now">
                                        <div class="add_to_cart">
                                            <a href="#"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                          @endforeach
                            

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
   
    <!-- End deal of the day  -->
    <!-- start shop by Catagorie  -->
    <div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>Shop by Catagorie</h3>
                <div class="swiper-pagination"></div>
            </div>

            <div class="catagorie_grid">
                @foreach ($Catagories as $Catagorie)
                    <a href="{{ url('catagorie/'.$Catagorie->slug) }}">
                    <div class="card catagorie">
                        <div class="catagorie_content">
                            <div class="catagorie_img">
                                <img src="{{asset('storage/media/'.$Catagorie->catagorie_logo)}}" alt="product image">
                            </div>
                            <div class="catagorie_text">
                                <p>{{ $Catagorie->catagorie_name }}</p>
                            </div>
                            <div>
                                <p><i class="fas fa-angle-right"></i></p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- End deal of the day end  -->
    <!-- start shop by Brand  -->
    <div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>Shop by Brands</h3>
                <div class="swiper-pagination"></div>
            </div>

            <div class="catagorie_grid text-center">
        @if (!$Brands->isEmpty())
            @foreach ($Brands as $Brand)
                <a href="{{ url('brand/'.$Brand->slug) }}">
                    <div class="card catagorie">
                        <div class="catagorie_content">
                            <div class="catagorie_img">
                                <img src="{{asset('storage/media/'.$Brand->brand_logo)}}" alt="product image">
                            </div>
                            <div class="catagorie_text">
                                <p>{{ $Brand->brand_name }}</p>
                            </div>
                            <div>
                                <p><i class="fas fa-angle-right"></i></p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
            </div>
        </div>
    </div>
    <!-- start shop by Brands end  -->
    <!-- recent products start  -->
    @if (!$RecentUploadedProducts->isEmpty())
        <div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>Recent Products</h3>
            </div>

            <div class="card">
                <div class="product_section card_section">
                    @foreach ($RecentUploadedProducts as $RProduct)
                        <div class="card_items">
                        <a href="{{ url('product/'.$RProduct->slug) }}">
                            <div class="img">
                                <img src="{{asset('storage/product_images/'.$RProduct->PImage->image)}}" alt="product image">
                                @if ($RProduct->discount != '')
                                    <div class="discount">
                                        @if ($RProduct->discount_type == 'flat')&#8377;&nbsp;  @endif
                                        {{ $RProduct->discount }}
                                        @if ($RProduct->discount_type == 'percentage')%@endif
                                        OFF
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                <div class="price">
                                    @if ($RProduct->discount == '')
                                        <div class="selling_price">
                                            <p>&#8377; <span>{{ $RProduct->unit_price }}.00</span></p>
                                        </div>
                                    @else
                                        <div class="selling_price">
                                            <p>&#8377; <span>{{ $RProduct->discounted_price }}.00</span></p>
                                        </div>
                                        <div class="original_price">
                                            <p>&#8377; <span>{{ $RProduct->unit_price }}</span></p>
                                        </div>
                                    @endif
                                </div>
                                <div class="rating text-center">
                                    &#11088;&#11088;&#11088;&#11088;&#11088;
                                </div>
                                <p class="p_name">Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet
                                    consectetur.lorem Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit.</p>
                            </div>
                        </a>
                        <div class="add_to_cart_buy_now">
                            @if ($RProduct->quantity > 0)
                                <div class="add_to_cart">
                                    <a id="{{ $RProduct->id }}" items="item"><i class="fas fa-cart-plus"></i> <span>Add to Cart</span></a>
                                </div>
                                @else
                                <div class="add_to_cart">
                                     out of stock
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    @endif
    
@endsection