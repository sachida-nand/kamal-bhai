@extends('layouts.frondEndApp')
@section('title-section')
Checkout | {{ @config('constants.site_name') }}
@endsection
@section('content')
<script>
    var AddnewAddress = "{{ route('addNewAddAjax') }}";
</script>
@php
$unit_price = 0;
$selling_price = 0;
$delivery_charge = 0;
$checkIsCod = 0;
@endphp
<div class="card_container" id="sss">
        <div class="row">
            <div class="col-lg-8 col-sm 12">
               <h4>Checkout</h4>
               <div class="card">
                <div class="oder_preview">
                    <div class="header">
                        <h5>Shipping Details</h5>
                    </div>
                    <hr>
                <div class="error alert-warning" role="alert">
                
                </div>
                @if (!$UserAddresses->isEmpty())
                <form action="{{ route('place-order') }}" method="post">
                 @csrf
                 @if ($qty != 0)
                     <input type="hidden" name="product_id" value="{{ $Products[0]->id }}">
                     <input type="hidden" name="qty" value="{{ $qty }}">
                 @else
                     <input type="hidden" name="from_cart" id="">
                 @endif
                <div class="shipment_address">
                     @foreach ($UserAddresses as $Address)
                          <div class="address_item my-3">
                            <div class="row">
                                <div class="col-1">
                                    <div class="radio-button text-center">
                                        <input type="radio" name="address" id="address{{ $Address->id }}" onchange="hideAddNewAddressFrom('address{{ $Address->id }}')" value="{{ $Address->id }}" required>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="name_phone">
                                        <label for="address{{ $Address->id }}">
                                            <p>{{ $Address->full_name }}<span>{{ $Address->address_type }}</span> {{ $Address->mobile }}</p>
                                            <small>{{ $Address->city_town.', '.$Address->address_one.', '.$Address->address_two.', '.$Address->landmark.', '.$Address->district.'-'.$Address->pincode }}
                                               </small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                     @endforeach
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-lg-3">
                            <p class="mb-3">OR</p>
                            <label for="addnewaddressinput" id="add_new_address" class="btn btn-primary mb-3">+ Add New Address</label>
                        </div>
                    </div>
                </div>
                <div class="payment_details">
                    <div class="header">
                        <h5>Payment Method</h5>
                    </div>
                    <hr>
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="radio" onclick="showHidePaymentOption('khalti')" name="payment"
                            id="khalti" required>
                        <label class="form-check-label" for="khalti">
                            Khalti
                        </label>
                        <div class="payment_method khalti">
                            <button class="btn btn-warning">Pay By Khalti</button>
                        </div>
                    </div> --}}
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" onclick="showHidePaymentOption('eSewa')" name="payment" id="eSewa" value="eSewa" required>
                        <label class="form-check-label" for="eSewa">
                            eSewa
                        </label>
                        <div class="payment_method eSewa">
                            <button id="" class="btn btn-warning">Pay By eSewa</button>
                        </div>
                    </div>
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" onclick="showHidePaymentOption('cod')" name="payment" id="cod" value="COD" required>
                        <label class="form-check-label" for="cod">
                            Cash On Delivery (COD)
                        </label>
                        
                        @foreach ($Products as $Product)
                            @if ($Product->cash_on_delivery == 'no')
                                @php
                                    $checkIsCod = 1
                                @endphp
                            @endif
                        @endforeach
                        <div class="payment_method cod">
                            @if ($checkIsCod != 1)
                                 <button id="COD" name="codelivery" class="btn btn-warning">Confirm Order</button>
                               @else
                                 <p class="btn btn-warning">Cash On Delivery (COD) not available for this item choose anoter payment options.</p>
                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="add_new">
                    <div class="header">
                        <div class="radio-button add_input text-center">
                            &nbsp;&nbsp; <input type="radio" name="address" id="addnewaddressinput" required>&nbsp;&nbsp; <b>Add New Address</b>
                        </div>
                    </div><hr>
                </div>
                </form>
                 @else
                 {{-- if address not found in addressbook  --}}
                 <form action="" method="post" id="AddnewAddress">
                    <div class="add_new_adress">
                        <div class="mt-3 pt-4 add_new_form_section">
                            <div class="add_new_section">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="mobile" id="mobile"
                                                placeholder="10-digit mobile number" required>
                                        </div>
                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="pincode">Pin/Zip code</label>
                                            <input type="text" class="form-control" name="pincode" placeholder="Pincode" id="pincode">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="city">City/Town <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City/Town" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="address">
                                    <div class="form-group">
                                        <label for="flate">Flate/House No./Building/Comapany/Apartment <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address_one" id="flate" placeholder="Address"
                                            required>
                                    </div>
                                </div>
                                <div class="address_two">
                                    <div class="form-group">
                                        <label for="area">Area/Colony/Sector/Village</label>
                                        <input type="text" class="form-control" name="address_two" id="area" placeholder="Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="landmark">Landmark</label>
                                            <input type="text" class="form-control" name="landmark" id="landmark"
                                                placeholder="E.g. Near Ghati Chock">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="district">District <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="district" placeholder="District" id="district" required>
                                    </div>
                                </div>
                                <p class="mb-2">Address Type <span class="text-danger">*</span></p>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-check">
                                             <input type="radio" name="address_type" id="home" value="HOME" required>
                                            <label class="form-check-label" for="home">
                                                Home (Delivery between 7 AM - 9 PM)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-check">
                                           <input type="radio" name="address_type" id="work" value="WORK" required>
                                            <label class="form-check-label" for="work">
                                                Work (Delivery between 10 AM - 5 PM)
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="new_add_butto mt-4 pb-4">
                            <button class="btn btn-warning savee">SAVE AND CONTINUE</button>
                            <span href="javascript:void()" id="Cancel" class="btn btn-danger">Cancel</span>
                        </div>
                    </div>
                </form>
                @endif
                {{-- add through javascript --}}
                <form action="" method="post" id="AddnewAddress">
                    <div class="add_new_adress">
                        <div class="mt-3 pt-4 add_new_form_section">
                            
                        </div>
                        <div class="new_add_button mt-4 pb-4">
                            <button class="btn btn-warning savee">SAVE AND CONTINUE</button>
                            <span href="javascript:void()" id="Cancel" class="btn btn-danger">Cancel</span>
                        </div>
                    </div>
                </form>
               </div>
               </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="price_details">
                    <div class="card">
                        <div class="heading">
                            <h4>ORDER SUMMARY</h4>
                        </div>
                        <hr>
                         <div class="product_details">
                            {{-- @if (!$Products->isEmpty()) --}}
                                @foreach ($Products as $Product)
                                    <div class=" py-2">
                                        <div class="row">
                                            <div class="col-2 ">
                                               <div class="pl-1">
                                                    <img src="{{ asset('storage/product_images/'.$Product->image) }}" alt="" width="50">
                                               </div>
                                            </div>
                                            <div class="col-10">
                                                <p style="margin-bottom: 0;">{{ $Product->product_name }}</p>
                                                @if ($Product->discount == '')
                                                    <small class="warninng">&#8377; {{ $Product->unit_price }}</span>&nbsp; x &nbsp;{{ $qty != 0 ? $qty : $Product->qty }}</small>
                                                    @else
                                                    <small class="warninng">&#8377; {{ $Product->discounted_price }}&nbsp;&nbsp; <span ><del>&#8377; {{ $Product->unit_price }}</del></span>&nbsp; x &nbsp;{{ $qty != 0 ? $qty : $Product->qty }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        if($Product->discount == ''){
                                            if($qty != 0){
                                               $selling_price = $selling_price + ($Product->unit_price * $qty); 
                                            }else {
                                                $selling_price = $selling_price + ($Product->unit_price * $Product->qty);
                                            }
                                        }
                                        if($qty != 0){
                                            $unit_price = $unit_price + ($Product->unit_price * $qty);
                                            $selling_price = $selling_price + ($Product->discounted_price * $qty);
                                        }else{
                                            $unit_price = $unit_price + ($Product->unit_price * $Product->qty);
                                            $selling_price = $selling_price + ($Product->discounted_price * $Product->qty);
                                        }
                                        

                                        if($Product->is_qty_mply == 'yes'){
                                            if($qty !=0){
                                                $delivery_charge = $delivery_charge + ($Product->shipping_cost * $qty);
                                            }else{
                                                $delivery_charge = $delivery_charge + ($Product->shipping_cost * $Product->qty);
                                            }
                                        }else{
                                           $delivery_charge = $delivery_charge + $Product->shipping_cost;
                                        }
                                        // $item_count++;
                                    @endphp
                                @endforeach
                            {{-- @endif --}}
                         </div>
                         <hr>
                        <div class="items">
                            <div class="d-flex justify-content-between">
                                <p>Price ({{ count($Products) }} items)</p>
                                <span>&#8377; {{ $unit_price }}.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Discount</p>
                                <span class="text">- &#8377; {{$unit_price - $selling_price }}.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Delivery Charges</p>
                                <span>&#8377; {{ $delivery_charge }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p><b>Total Amount</b></p>
                                <span><b>&#8377; {{ $selling_price + $delivery_charge }}.00</b></span>
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
    </div>
@endsection
@section('script')

@endsection