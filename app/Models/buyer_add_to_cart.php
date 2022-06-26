<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class buyer_add_to_cart extends Model
{
    use HasFactory;

    static public function SaveShoppingCard($request,$Condition)
    {  
        if(Auth::check()){
            $user = Auth::user()->id;
        }

        if($Condition == 'UpdateCart')
        {
            $Cart = buyer_add_to_cart::where('user_id','=', $user)
                           ->where('product_id','=', $request->ProductId)
                           ->first();
        }else{
            $Cart = new buyer_add_to_cart();
            $Cart->user_id = $user;
            $Cart->product_id = $request->ProductId;
        }   
        $Cart->qty = $request->qty;
        $Cart->save();
        
        return $Cart->id;
    }

    static public function CheckCartData($ParaMeter)
    {
       $CartItems = buyer_add_to_cart::where('user_id', $ParaMeter['user_id'])
                   ->where('product_id', $ParaMeter['id'])
                   ->get();
          return $CartItems;
    }

    static public function GetAllCartItems($ParaMeter)
    {
     
        $CartItems = buyer_add_to_cart::select('buyer_add_to_carts.id');  
        if (isset($ParaMeter['user_id']) && $ParaMeter['user_id'] > 0)
         {
            $CartItems = $CartItems->join('products', 'products.id', 'buyer_add_to_carts.product_id')
            ->join('product_images', 'product_images.product_id', 'products.id')
            ->where('buyer_add_to_carts.user_id', $ParaMeter['user_id'])
            ->addSelect('buyer_add_to_carts.*', 'buyer_add_to_carts.id as cart_item_id', 'products.*', 'product_images.image')
            ->groupBy('products.id')
            ->orderBy('buyer_add_to_carts.id', 'DESC')
            ->get();
        }
        return $CartItems;
    }

    static public function DeleteCartItem($ParaMeter){
         if(isset($ParaMeter['user_id'])){
            $cart = buyer_add_to_cart::where('user_id', $ParaMeter['user_id'])
                    ->where('product_id',$ParaMeter['product_id'])
                    ->delete();
         }
         return $cart;
    }
}
