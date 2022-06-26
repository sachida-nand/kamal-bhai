<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Mail\CancelOrderMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $OrderItems = Order::GetOrderItems($userId);
        return view('frontEnd.orders', compact('OrderItems'));
    }

    public function SingleOrder($type, $order_id)
    {
        $userId = Auth::user()->id;
        $OrderItems = Order::GetOrderItems($userId);
        if ($type == 'order_id') {
            $Order = Order::where('order_id', $order_id)->first();

            if ($Order) {
                return view('frontEnd.orderSingle', compact('Order'));
            } else {
                $msg = 'Order Not found';
                return view('frontEnd.orders', compact('OrderItems', 'msg'));
            }
        } else {
            $msg = 'Order Not found';
            return view('frontEnd.orders', compact('OrderItems', 'msg'));
        }
    }

    public function CancelOrder(Request $request)
    {
        $Order_number = $request->post('order_id');
        $Cancel_reason = $request->post('cancel_reason');
        $add_cncl_msg = $request->post('addional_msg');
        $Cancel_by = $request->post('cancel');

        $Order = Order::where('order_id', $Order_number)->first();

        if ($Order) {
            $Order->cancel_reason = $Cancel_reason;
            $Order->addition_reason = $add_cncl_msg;
            $Order->cancel_by = $Cancel_by;
            $Order->order_status = 'Cancel';
            $Order->save();

            foreach ($Order->itemDetails as $product_item) {
                $ProductId = $product_item->product_id;
                $CancelProduct = Product::find($ProductId);
                $new_stock = ($CancelProduct->quantity + $product_item->qty);
                $sold_stock = ($CancelProduct->product_sold - $product_item->qty);
                Product::find($ProductId)->update(['quantity' => $new_stock, 'product_sold' => $sold_stock]);
            }
           
            $EmailData = [
               'name' => $Order->name,
               'order_id' => $Order->order_id,
               'reason' => $Cancel_reason
            ];
            
            Mail::to('vickysharma.mv@gmail.com')->send(new CancelOrderMail($EmailData));
            return redirect('order-details/order_id=' . $Order_number,)
                ->with('msg', 'Your Order has been Canceled! If you already paid for this item admin can contact you sortly.');
        } else {
            $msg = 'Order not fount for this order id';
            return redirect('order-details/order_id=' . $Order_number)->with('error', $msg);
        }
    }
}
