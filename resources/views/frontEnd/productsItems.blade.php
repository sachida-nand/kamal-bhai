@extends('layouts.frondEndApp')
@section('title-section')
{{ $Search. ' | ' .@config('constants.site_name') }}
@endsection
@section('content')
<div class="container-fluid">
        <div class="main">
            <div class="header">
                <h3>{{ $Search }}</h3>
            </div>

            <div class="card">
                @if (!$Products->isEmpty())
                    <div class="product_section card_section">

                    @foreach ($Products as $Product)
                        <div class="card_items">
                        <a href="{{ url('product/'.$Product->slug) }}">
                            <div class="img">
                                <img src="{{asset('storage/product_images/'.$Product->PImage->image)}}" alt="">
                                @if ($Product->discount != '')
                                    <div class="discount">
                                      @if ($Product->discount_type == 'flat')&#8377;&nbsp;  @endif
                                      {{ $Product->discount }}
                                      @if ($Product->discount_type == 'percentage')%@endif
                                      OFF
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                <div class="price">
                                    @if ($Product->discount == '')
                                        <div class="selling_price">
                                           <p>&#8377; <span>{{ $Product->unit_price }}.00</span></p>
                                        </div>
                                        @else
                                        <div class="selling_price">
                                           <p>&#8377; <span>{{ $Product->discounted_price }}.00</span></p>
                                        </div>
                                        <div class="original_price">
                                           <p>&#8377; <span>{{ $Product->unit_price }}</span></p>
                                        </div>
                                    @endif
                                </div>
                                <div class="rating text-center">
                                    &#11088;&#11088;&#11088;&#11088;&#11088;
                                </div>
                                <p class="p_name">{{$Product->product_name}}</p>
                            </div>
                        </a>
                        <div class="add_to_cart_buy_now">
                            @if ($Product->quantity > 0)
                                <div class="add_to_cart">
                                    <a id="{{ $Product->id }}" items="item"><i class="fas fa-cart-plus"></i> <span>Add to Cart</span></a>
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
                @else
                  <p class="text-center mt-2 h3">Oops! Product not found</p>
                @endif
                
            </div>
        </div>
    </div>
@endsection