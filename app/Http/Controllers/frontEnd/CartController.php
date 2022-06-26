<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Models\buyer_add_to_cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Return_;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class CartController extends Controller
{
    public function AddToCart(Request $request)
    {

        $ParaMeter['id'] = $request->ProductId;
        $ParaMeter['type'] = 'cartProduct';
        $Product = Product::GetSingleProduct($ParaMeter);

        $ProductId = $Product->id;
        $ProductQty = $request->qty;
        $ProductName = $Product->product_name;
        $unit_price = $Product->unit_price;
        $discounted_price = $Product->discounted_price;
        $discount = $Product->discount;
        $quantity = $Product->quantity;
        $image = $Product->image;
        $disc_type = $Product->discount_type;
        $free_shipping = $Product->free_shipping;
        $is_qty_mply = $Product->is_qty_mply;
        $shipping_cost = $Product->shipping_cost;
        $minimum_purchage_qty = $Product->minimum_purchage_qty;
        $slug = $Product->slug;

        if (Auth::check()) {
            $ParaMeter['user_id'] = Auth::user()->id;
            $CartItem = buyer_add_to_cart::CheckCartData($ParaMeter);

            if (!$CartItem->isEmpty()) {
                $msg = 'Already in Cart';
            } else {
                $Condition = 'AddNewItem';
                buyer_add_to_cart::SaveShoppingCard($request, $Condition);
                $msg = 'Added to Cart';
            }
        } else {
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);
            } else {
                $cart_data = array();
            }

            $cart_id_list = array_column($cart_data, 'product_id');

            if (in_array($ProductId, $cart_id_list)) {

                foreach ($cart_data as $keys => $value) {
                    if ($cart_data[$keys]['product_id'] == $ProductId) {
                        $cart_data[$keys]['qty'] = $ProductQty;
                        $minutes = 30;
                        cookie::queue(cookie::make('shopping_cart', json_encode($cart_data), $minutes));
                        $msg = 'Already in Cart';
                    }
                }
            } else {
                $Item_array = array(
                    'product_id' => $ProductId,
                    'product_name' => $ProductName,
                    'qty' => $ProductQty,
                    'unit_price' => $unit_price,
                    'discounted_price' => $discounted_price,
                    'discount' => $discount,
                    'quantity' => $quantity,
                    'discount_type' => $disc_type,
                    'image' => $image,
                    'slug' => $slug,
                    'free_shipping' => $free_shipping,
                    'is_qty_mply' => $is_qty_mply,
                    'shipping_cost' => $shipping_cost,
                    'minimum_purchage_qty' => $minimum_purchage_qty,
                );

                $cart_data[] = $Item_array;
                $minutes = 30;

                Cookie::queue(Cookie::make('shopping_cart', json_encode($cart_data), $minutes));
                $msg = 'Added to Cart';
            }
        }
        return response()->json(['status' => $msg, 'P_name' => $ProductName]);
    }

    public function UpdateCartQty(Request $request)
    {
        $ParaMeter['id'] = $request->ProductId;
        $ParaMeter['type'] = 'cartProduct';

        if (Auth::check()) {
            $ParaMeter['user_id'] = Auth::user()->id;
            $CartItem = buyer_add_to_cart::CheckCartData($ParaMeter);

            if (!$CartItem->isEmpty()) {
                $Condition = 'UpdateCart';
                $update = buyer_add_to_cart::SaveShoppingCard($request, $Condition);
                if ($update) {
                    $msg = 'Quentity updated';
                }
            }
        } else {
            if (cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);

                $cart_id_list = array_column($cart_data, 'product_id');

                if (in_array($ParaMeter['id'], $cart_id_list)) {
                    foreach ($cart_data as $keys => $value) {
                        if ($cart_data[$keys]['product_id'] == $ParaMeter['id']) {
                            $cart_data[$keys]['qty'] = $request->qty;
                            $minutes = 30;
                            cookie::queue(cookie::make('shopping_cart', json_encode($cart_data), $minutes));
                            $msg = 'Quentity updated';
                        }
                    }
                }
            }
        }
        return response()->json(['status' => $msg]);
    }


    public function AddShoppingCartItemCookieToDatabase()
    {
        if (Auth::check()) {
            $user = Auth::user()->id;
            if (cookie::get('shopping_cart')) {
                $Products = cookie::get('shopping_cart');
                $item =  json_decode($Products, true);

                foreach ($item as $key => $value) {
                    $Product_id_inCookie = $item[$key]['product_id'];

                    $Products = buyer_add_to_cart::where('user_id', $user)
                        ->where('product_id', $Product_id_inCookie)
                        ->first();
                    if (!$Products) { // if item not found in shoping table then save new data 
                        $cart = new buyer_add_to_cart();
                        $cart->user_id = $user;
                        $cart->product_id = $Product_id_inCookie;
                        $cart->qty = $item[$key]['qty'];
                        $cart->save();
                    }
                    Cookie::queue(Cookie::forget('shopping_cart'));
                }
            }
        }
    }

    public function DisplayCartItem($url)
    {
        // cookie::queue(cookie::forget('shopping_cart'));
        $status = 0;
        if (Auth::check()) {
            $Parameter['user_id'] = Auth::user()->id;
            $CartItems = buyer_add_to_cart::GetAllCartItems($Parameter);
            if ($CartItems->isEmpty()) {
                $CartItems = array();
            }
        } else {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $CartItems = json_decode($cookie_data);
            if (!isset($CartItems)) {
                $CartItems = array();
            }
        }
        return view('frontEnd.addToCart', compact('CartItems'));
    }

    public function CountCartItem(Request $request)
    {
          $TotalCount = 0;
        if (cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(cookie::get('shopping_cart'));
            $cart_item = json_decode($cookie_data, true);
            foreach($cart_item as $key => $value){
                $TotalCount += $cart_item[$key]['qty'];
            }
        } else if (Auth::check()) {
            $Parameter['user_id'] = Auth::user()->id;
            $CartItems = buyer_add_to_cart::GetAllCartItems($Parameter);
            foreach($CartItems as $cart_item){
                $TotalCount += $cart_item->qty;
            }
        }
        return response()->json(['count'=>$TotalCount]);
    }

    public function DeleteCartItem(Request $request)
    {
        $ProductId = $request->ProductId;

       if(Auth::check()){
            $ParaMeter['product_id'] = $ProductId;
            $ParaMeter['user_id'] = Auth::user()->id;
            $delete =buyer_add_to_cart::DeleteCartItem($ParaMeter);
            if($delete){
                $msg = 'Cart Item Deleted';
            }
       }else{
            $cookie_data = stripslashes(cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            $cart_id_list = array_column($cart_data, 'product_id');
            if (in_array($ProductId, $cart_id_list)) {
                foreach ($cart_data as $keys => $value) {
                    if ($cart_data[$keys]['product_id'] == $ProductId) {
                        unset($cart_data[$keys]);
                        $cart_data = json_encode($cart_data);
                        $minutes = 30;
                        Cookie::queue(cookie::make('shopping_cart', $cart_data, $minutes));
                        $msg = 'Cart Item Deleted';
                    }
                }
            }
       }
       return response()->json(['status'=>$msg]);
    }
}
