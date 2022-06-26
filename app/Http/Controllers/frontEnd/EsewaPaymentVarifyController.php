<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmOrderEmail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EsewaPaymentVarifyController extends Controller
{
    public function VarifyPayment(Request $request)
    {

        if($request->q == 'su'){
            $order_id = $request->oid;
            $eSewa_reference_id = $request->refId;
            $tAmt = $request->amt;
            
            $SubTotal = 0;
            $deliveryCharge = 0;
            $Total = 0;

            $orderDetails = Order::where('order_id', $order_id)->first();

            foreach($orderDetails->itemDetails as $items){
                $SubTotal += $items->price * $items->qty;
                $deliveryCharge += $items->shipping_charge * $items->qty;
            }
            $Total = $SubTotal + $deliveryCharge;

            $eamilData = [
                'order_id' => $orderDetails->order_id,
                'name' => $orderDetails->name,
                'city' => $orderDetails->city,
                'district' => $orderDetails->district,
                'pincode' => $orderDetails->pincode,
                'subtotal' => $SubTotal,
                'delivery_charge' => $deliveryCharge,
                'total' => $Total,
                'payment_type' => 'eSewa (Online)',
            ];

            if($orderDetails != null){
                $url = "https://uat.esewa.com.np/epay/transrec";
                $data = [
                    'amt' => $orderDetails->total_amount,
                    'rid' => $eSewa_reference_id,
                    'pid' => $orderDetails->order_id,
                    'scd' => 'EPAYTEST'
                ];

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);
                
                if(strpos($response, 'Success') !== false){
                    $orderDetails->payment_id = $eSewa_reference_id;
                    $orderDetails->payment_status = 'Paid'; 
                    // $orderDetails->order_status = 'Ordered'; 
                    $orderDetails->save();

                    Mail::to('vickysharma.mv@gmail.com')->send(new ConfirmOrderEmail($eamilData));
                    return redirect('/');
                }else{
                    echo 'payment failed';
                }   
            }else{
                echo 'kisi or page pe bhejna h';
            }
        }else{
            echo 'payment failed';
        }
    }
}
