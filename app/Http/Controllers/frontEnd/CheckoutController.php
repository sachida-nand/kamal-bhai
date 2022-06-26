<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Models\buyer_add_to_cart;
use App\Models\Order;
use App\Models\Order_detail;
use App\Mail\ConfirmOrderEmail;
use App\Models\Product;
use App\Models\User_address_book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $qty = 0;
            $userId = Auth::user()->id;
            if (isset($request->from_details_page)) {
                $ParaMeter['id'] = $request->input('product_id');
                $ParaMeter['type'] = 'cartProduct';
                $Products = array(Product::GetSingleProduct($ParaMeter));
                $qty = $request->qty;
            } elseif (isset($request->from_cart_page)) {
                $ParaMeter['user_id'] = $userId;
                $Products = buyer_add_to_cart::GetAllCartItems($ParaMeter);
            }
            $UserAddresses = User_address_book::where('user_id', $userId)->get();
        }
        return view('frontEnd.checkout', compact('UserAddresses', 'Products', 'qty'));
    }

    public function PlaceOrder(Request $request)
    {
        if (Auth::check()) {
            $SubTotal = 0;
            $Total = 0;
            $deliveryCharge = 0;
            $taxAmount = 0;
            $qty = 0;
            $ParaMeter['user_id'] = Auth::user()->id;
        }

        if ($request->product_id) {
            // check order come from details page 
            $ParaMeter['id'] = $request->input('product_id');
            $ParaMeter['type'] = 'cartProduct';
            $Products = array(Product::GetSingleProduct($ParaMeter));
            $qty = $request->qty;
        } else {
            // check order from add to cart page 
            $Products = buyer_add_to_cart::GetAllCartItems($ParaMeter);
        }

        foreach ($Products as $Product) {
            if ($Product->qty) {
                $qty = $Product->qty;
            }
             
            if ($Product->discount == '') {
                $SubTotal = $SubTotal + ($Product->unit_price * $qty);
            } else {
                $SubTotal = $SubTotal + ($Product->discounted_price * $qty);
            }
            if ($Product->is_qty_mply == 'yes') {
                $deliveryCharge = $deliveryCharge + ($Product->shipping_cost * $qty);
            } else {
                $deliveryCharge = $deliveryCharge + $Product->shipping_cost;
            }
        }
   
        $Total = $SubTotal + $deliveryCharge;
        $Order_number = 'UEE-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        $ParaMeter['address_id'] = $request->input('address');
        $UserAddress = User_address_book::GetUserAddress($ParaMeter);

        $Order = new Order();
        $Order->user_id = $ParaMeter['user_id'];
        $Order->order_id = $Order_number;
        $Order->name = $UserAddress->full_name;
        $Order->mobile = $UserAddress->mobile;
        $Order->pincode = $UserAddress->pincode;
        $Order->address_one = $UserAddress->address_one;
        $Order->address_two = $UserAddress->address_two;
        $Order->landmark = $UserAddress->landmark;
        $Order->city = $UserAddress->city;
        $Order->district = $UserAddress->district;
        $Order->address_type = $UserAddress->address_type;
        // $Order->coupon_code = 
        // $Order->coupon_value = 
        $Order->order_status = 'Ordered';
        if ($request->payment == 'COD') {
            $Order->payment_type = 'cashondelivery_cod';
            $Order->payment_status = 'Unpaid';
        } else {
            $Order->payment_type = 'online_esewa';
            $Order->payment_status = 'Pending';

            $eSewa_url = "https://uat.esewa.com.np/epay/main";
            $order_data = [
                'amt' => $SubTotal,
                'pdc' => $deliveryCharge,
                'psc' => 0,
                'txAmt' => 0,
                'tAmt' => $Total,
                'pid' => $Order_number,
                'scd' => 'EPAYTEST',
                'su' => 'http://127.0.0.1:8000/varify-eSewa-payment/success?q=su',
                'fu' => 'http://127.0.0.1:8000/varify-eSewa-payment/failed?q=fu'
            ];

            $curl = curl_init($eSewa_url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $order_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
        }
        $Order->total_amount = $Total;
        $Order->save();

        $OrderId = $Order->id;

        foreach ($Products as $Product) {
            $OrderDetails = new Order_detail();

            $OrderDetails->order_id = $OrderId;
            $OrderDetails->product_id = $Product->id;

            if ($Product->qty) {
                $qty = $Product->qty;
            }
            $OrderDetails->qty = $qty;
            if ($Product->discount == '') {
                $OrderDetails->price = $Product->unit_price;
            } else {
                $OrderDetails->price = $Product->discounted_price;
            }
            // $OrderDetails->tax = 
            if ($Product->is_qty_mply == 'yes') {
                $OrderDetails->shipping_charge = $Product->shipping_cost * $qty;
            } else {
                $OrderDetails->shipping_charge = $Product->shipping_cost;
            }
            $OrderDetails->save();

            $ProductSold = Product::find($Product->id);
            $new_stock = ($ProductSold->quantity - $qty);
            $sold_stock = ($ProductSold->product_sold + $qty);
            $updateProductStock = Product::find($Product->id)->update(['quantity' => $new_stock, 'product_sold' => $sold_stock]);

            if (!$request->product_id) {
                $DeleteitemFromCart = buyer_add_to_cart::find($Product->cart_item_id);
                $DeleteitemFromCart->delete();
            }
        }

        $eamilData = [
            'order_id' => $Order_number,
            'name' => $UserAddress->full_name,
            'city' => $UserAddress->city,
            'district' => $UserAddress->district,
            'pincode' => $UserAddress->pincode,
            'subtotal' => $SubTotal,
            'delivery_charge' => $deliveryCharge,
            'total' => $Total,
            'payment_type' => $request->payment == 'COD' ? 'Cash on delivery (COD)' : 'eSewa (Online)',
        ];
    //    after order succesfully saved 
        if ($request->payment == 'COD') {
            Mail::to('vickysharma.mv@gmail.com')->send(new ConfirmOrderEmail($eamilData));
            return redirect('/');
        } else {
            return view('frontEnd.esewa', compact('eSewa_url', 'order_data'));
        }
    }
}
