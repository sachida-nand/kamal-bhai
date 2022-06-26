@extends('layouts.frondEndApp')
@section('title-section')
My Cart | {{ @config('constants.site_name') }}
@endsection
@section('content')
@php
$item_count = 0;
$unit_price = 0;
$selling_price = 0;
$delivery_charge = 0;
$out_of_stock = 0;
@endphp
<script>
    var stock = 0;
    var minpurchageqty = 0;
</script>
<div class="card_container container-flui">
    @if (!empty($CartItems))
    <div class="row">
        <div class="col-lg-8 col-sm-12 d">
                @foreach ($CartItems as $CartItem)
                <div class="cart_items">
                    <div class="card">
                        <div class="row">
                            <div class="col-2">
                                <div class="card_img ">
                                    <img src="{{ asset('storage/product_images/'.$CartItem->image) }}" alt="">
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="description">
                                    <a href="{{ url('product/'.$CartItem->slug) }}">
                                        <h1>{{ $CartItem->product_name }}</h1>
                                    </a>
                                    <div class="row">
                                            <div class="col-6 ">
                                                @if($CartItem->discount == '')
                                                <p>
                                                    <span class="selling_price">&#8377;
                                                        <span class="selling_pricee">{{
                                                            number_format($CartItem->unit_price*$CartItem->qty,2)
                                                            }}</span>
                                                    </span>
                                                </p>
                                                @else
                                                <p>
                                                    <span class="selling_price">&#8377;
                                                        <span class="selling_pricee">{{
                                                            number_format($CartItem->discounted_price*$CartItem->qty,2) }}</span>
                                                    </span>
                                                    <span class="market_price">&#8377; {{
                                                        number_format($CartItem->unit_price*$CartItem->qty,2)
                                                        }}</span>
                                                    <span class="discount_amount">(
                                                        @if($CartItem->discount_type == 'flat') &#8377;&nbsp; @endif
                                                        {{ $CartItem->discount }}
                                                        @if ($CartItem->discount_type == 'percentage')%@endif
                                                        OFF)
                                                    </span>
                                                </p>
                                                @endif
                                            </div>
                                            <div class="col-6 ">
                                                <small class="d">Delivery charge -
                                                    <span class="text">
                                                        @if ($CartItem->free_shipping == 'yes')
                                                        Free
                                                        @else
                                                        &#8377;
                                                        @if ($CartItem->is_qty_mply == 'yes')
                                                        {{ number_format($CartItem->shipping_cost * $CartItem->qty,2) }}
                                                        @else
                                                        {{ number_format($CartItem->shipping_cost,2) }}
                                                        @endif
                                                        @endif

                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    <div class="available">
                                        <p><b>Availability:</b> <span>{{ $CartItem->quantity <= 0 ? 'Out of stock'
                                                    : 'In stock' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="price_details details_price">

                        </div> --}}
                        <div class="row">
                            <div class="col-lg-2">

                            </div>
                            <div class="col-lg-10">
                                <div class="Quantity text-center">
                                    @if ($CartItem->quantity >= 0)
                                    <div class="quantity_input">
                                        <span class="decrease quantity_op"
                                            product_id="{{ $CartItem->product_id }}">-</span>
                                        {{-- <input type="number" value="{{ $CartItem->qty }}" class="quenty_value" />
                                        --}}
                                        <select class="quenty_value">
                                            @if ($CartItem->quantity < $CartItem->minimum_purchage_qty)
                                                @for ($qty = 1; $qty <= $CartItem->quantity; $qty++)
                                                   <option value="{{ $qty }}" {{ $CartItem->qty == $qty ? 'selected' :
                                                    '' }}>{{ $qty }}</option>
                                                @endfor
                                            @else
                                                @for ($qty = 1; $qty <= $CartItem->minimum_purchage_qty; $qty++)
                                                    <option value="{{ $qty }}" {{ $CartItem->qty == $qty ?
                                                        'selected' : '' }}>{{ $qty }}</option>
                                            @endfor
                                            @endif

                                        </select>
                                        @if($qty-1 == $CartItem->qty)
                                           <span class="text-warning">+</span>
                                        @else
                                          <span class="increase quantity_op"
                                            product_id="{{ $CartItem->product_id }}">+</span>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="">
                                        <p class="delete" product_id="{{ $CartItem->product_id }}"> <i
                                                class="fas fa-trash"></i> <span> Remove</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @php
                if($CartItem->discount == ''){
                $selling_price = $selling_price + ($CartItem->unit_price * $CartItem->qty);
                }
                $unit_price = $unit_price + ($CartItem->unit_price * $CartItem->qty);
                $selling_price = $selling_price + ($CartItem->discounted_price * $CartItem->qty);

                if($CartItem->is_qty_mply == 'yes'){
                $delivery_charge = $delivery_charge + ($CartItem->shipping_cost * $CartItem->qty);
                }else{
                $delivery_charge = $delivery_charge + $CartItem->shipping_cost;
                }
                $item_count++;

                if( $CartItem->quantity <= 0){
                    $out_of_stock = 1;
                }
                @endphp
                @endforeach
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="dd">
                <div class="price_details">
                    <div class="card">
                        <div class="heading">
                            <h4>PRICE DETAILS</h4>
                        </div>
                        <hr>
                        <div class="items">
                            <div class="d-flex justify-content-between">
                                <p>Price ({{ $item_count }} items)</p>
                                <span>&#8377; {{ number_format($unit_price,2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Discount</p>
                                <span class="text">- &#8377; {{ number_format($unit_price - $selling_price,2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Delivery Charges</p>
                                <span>&#8377; {{ number_format($delivery_charge,2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p><b>Total Amount</b></p>
                                <span><b>&#8377; {{ number_format($selling_price + $delivery_charge,2) }}</b></span>
                            </div>
                            <hr>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="from_cart_page" value="fromCartPage">
                                <div class="text-center">
                                    @if ($out_of_stock == 1)
                                        <p class="buy_nows">Some item in cart is out of stock remove these to Checkout</p>
                                    @else
                                       <button class="buy_nows">PROCEED TO CHECKOUT</button>
                                    @endif 
                                </div>
                            </form>
                            {{-- <span class="text">You will save ₹ {{$unit_price - $selling_price }}.00 on this
                                order</span> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="options my-4">
                <div class="row">
                    <div class="col-1">
                        <img src="{{ asset('media/shield.png') }}" alt="">
                    </div>
                    <div class="col-11">
                        <p>Safe and Secure Payments. Easy returns. 100% Authentic products.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <h5><b>You have no items in your shopping cart.</b></h5>
        @if (!Auth::user())
        <p>Seems like you're not logged in. <a href="{{ route('login') }}">Click here to login.</a></p>
        @endif
        <p>Click <a href="{{ url('/') }}">here</a> to continue shopping.</p>
    </div>
    @endif
</div>
@endsection