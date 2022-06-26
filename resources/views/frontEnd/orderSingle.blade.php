@extends('layouts.frondEndApp')
@section('title-section')
Single Order | {{ @config('constants.site_name') }}
@endsection
@section('content')
@php
    $ItemSubtotal = 0;
    $DeliveryCharge = 0;
    $TaxAmount = 0;
    $CouponValue = 0;
    $Total = 0;
    $GrandTotal = 0;

    $Statuses = ['Ordered','Packed','Shipped','OFD','Delivered','Cancel'];
@endphp
<div class="orders mt-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('your-account') }}">Your Account</a></li>
                <li class="breadcrumb-item"><a href="{{ url('order-history') }}">Your Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
        </nav>
        <div class="heading mb-2">
            <h3>Order Details</h3>
        </div>
        <div class="card">
            <div class="order_details_section">
                <div class="order_num order_on mt-3">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <p><b>Order # {{ $Order->order_id }}</b></p>
                        </div>
                        <div class="order_on col-lg-6 col-sm-12 text-lg-right">
                            @php
                                $expectedDeliveryDate = 0;
                                foreach ($Order->itemDetails as $itemD) {
                                    if($expectedDeliveryDate < $itemD->ProductDetails->est_shipping_time){
                                        $expectedDeliveryDate = $itemD->ProductDetails->est_shipping_time;
                                    }
                                }
                                $expectedDeliveryDate = $Order->created_at->addDay($expectedDeliveryDate);
                            @endphp
                            <p><b>Expected Delivery: {{date_format($expectedDeliveryDate,'D, j M Y')}}</b></p>

                        </div>
                    </div>

                </div>
                <div class="order_on">
                    <p><b>Ordered on: {{ date_format($Order->created_at,"j F Y") }}</b></p>
                </div>
               @if ($message = Session::get('msg'))
                    <div class="alert alert-warning" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <div class="order_status">
                    <p id="order_in_mobile">Click here check Status <i id="icon" class="fas fa-angle-up"></i></p>
                    <?php
                       $OStatus = $Order->order_status;
                       $i= 0;
                       while ($OStatus != $Statuses[$i]) {
                           $i+=1;
                       }
                    ?>
                    <div class="progressbar-track" id="ss">
                        <ul class="progressbar">
                            @if ($Order->order_status == 'Cancel')
                               <li class="step-2 active">Ordered <span>{{ date_format($Order->created_at,"j F Y") }}</span></li> 
                               <li class="step-5 cancel">Canceled <span>{{ date_format($Order->updated_at,"j F Y") }}</span></li>
                            @else
                                @if ($i>=0)
                                    <li class="step-2 active">Ordered <span>{{ date_format($Order->created_at,"j M Y") }}</span></li>
                                @endif
                                @if ($i >=1)
                                    <li class="step-1">Packed <span>22/05/2021</span></li>
                                @endif
                                @if ($i >=2)
                                    <li class="step-3">Shipped <span>22/05/2021</span></li>
                                @endif
                                @if ($i >=3)
                                    <li class="step-4">Out for Delivery <span>22/05/2021</span></li>
                                @endif
                                @if ($i >=4)
                                    <li class="step-5">Delivered <span>{{ date_format($Order->updated_at,"j M Y") }}</span></li>
                                @endif
                            @endif
                            
                            @if ($Order->order_status != 'Cancel' && $Order->order_status != 'Delivered')
                                <span class="desk"><p pid="{{ $Order->order_id }}" class="review cancel_single_order">Cancel</p></span>
                            @endif
                        </ul>
                    </div>
                    @if ($Order->order_status == 'Cancel' && $Order->cancel_by == 'user')
                        <p>You requested a cancellation due to {{ $Order->cancel_reason != '' ? $Order->cancel_reason : '...' }}</p>
                    @elseif($Order->order_status == 'Cancel' && $Order->cancel_by == 'admin')
                         <p>Your order canceled by admin due to {{ $Order->cancel_reason != '' ? $Order->cancel_reason : '...' }}</p>
                    @endif
                </div>
                <div class="ship_details">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <h5>Shipping Address</h5>
                            <p>{{ $Order->name}}</p>
                            <p>{{$Order->address_one}}</p>
                            <p>{{$Order->address_two}}</p>
                            <p>{{$Order->landmark}}</p>
                            <p>{{$Order->city.', '.$Order->district.'-'.$Order->pincode}}</p>
                            <p>phone:- {{$Order->mobile}}</p>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <h5>Payment Method</h5>
                            <p>
                                @if ($Order->payment_type == 'cashondelivery_cod')
                                Cash on Delivery (COD)
                                @elseif ($Order->payment_type == 'online_esewa')
                                eSewa (Online)
                                @endif
                            </p>
                        </div>
                        @foreach ($Order->itemDetails as $Item)
                            @php
                                $ItemSubtotal += $Item->price * $Item->qty;
                                $DeliveryCharge += $Item->shipping_charge;
                                $TaxAmount = 0;
                                $CouponValue = 0;
                                $Total = 0;
                                $GrandTotal = 0; 
                            @endphp
                        @endforeach
                        <div class="col-lg-4 col-sm 12 ">
                            <div class="order_summary">
                                <h5>Order Summary</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Item({{ count($Order->itemDetails) }}) Subtotal:</p>
                                        <p>Shipping:</p>
                                        <p>Tax:</p>
                                        <p>Total:</p>
                                        <p><b>Grand Total:</b></p>

                                    </div>
                                    <div class="col-6">
                                        <p>&#8377; {{ number_format($ItemSubtotal,2) }}</p>
                                        <p>&#8377; {{ number_format($DeliveryCharge,2) }}</p>
                                        <p>&#8377; 0</p>
                                        <p>&#8377; {{ number_format($ItemSubtotal + $DeliveryCharge,2) }}</p>
                                        <p><b>&#8377; {{ number_format($ItemSubtotal + $DeliveryCharge,2) }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($Order->itemDetails as $Item)
                <div class="ship_product_details">
                    <div class="ship_product_item">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                            <a href="{{ url('product/'.$Item->ProductDetails->slug) }}">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="pl-1 ship_img">
                                            <img src="{{ asset('storage/product_images/'.$Item->ProductImage->image) }}" alt="" width="50">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-10">
                                            <p style="margin-bottom: 0;">
                                                {{ $Item->ProductDetails->product_name }}
                                            </p>
                                            <p>&#8377;{{ number_format($Item->price,2).' x '.$Item->qty }}</p>
                                            <p>{{ $Item->shipping_charge != '' ? 'Shipping Charge: '.$Item->shipping_charge.'.00' : '' }}</p>
                                            {{-- <p>{{ $Item->shipping_charge != '' ? 'Shipping Charge: '.$Item->shipping_charge.'.00' : '' }}</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                            <div class="col-lg-4 col-sm-12 mb-3 mt-4 write_review text-center">
                                @if ($Order->order_status == 'Delivered')
                                    <p><a href="{{ url('product-review/for_product='.$Item->ProductDetails->slug.'&order_id='.$Order->order_id) }}" class="review">Write a product review</a></p>
                                @endif
                                
                                {{-- <p><a href="#" class="review">Cancel Order For this Product</a></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="write_review text-center ">
                  @if ($Order->order_status != 'Cancel' && $Order->order_status != 'Delivered')
                    <p class="review mobile cancel_single_order btn-block">Cancel Order</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select order cancellation reason</h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('cancel.order') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $Order->order_id }}">
            <div class="form-group">
            <label for="cancel">Select reason *</label>
            <select name="cancel_reason" id="cancel" class="form-control" required>
                <option value="">Select reason...</option>
                <option>Place order by mistake.</option>
                <option>Cash not available for COD.</option>
                <option>Address is not correct.</option>
                <option>I want to change my phone number.</option>
                <option>I want to change my address.</option>
                <option>Product is not required anymore.</option>
                <option>Product is taking too long to be delivered.</option>
                <option>I changes mind and opts for another brand instead.</option>
                <option>Recipient not available at the estimated time/day of delivery.</option>
                <option>If you are not going to be available in town due to some urgent travel.</option>
                <option>Product is being delivered to a wrong address.</option>
                <option>Cheaper alternative available for lesser price.</option>
                <option>Other</option>
            </select>
            </div>
            <input type="hidden" name="cancel" value="user">
           <div class="form-group mt-3">
                <label for="addional_msg">Additional reason</label>
                <textarea class="form-control" name="additional_msg" id="addtional_reson" rows="3"></textarea>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Confirm</button>
             </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
@endsection