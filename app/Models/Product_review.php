<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product_review extends Model
{
    use HasFactory;

  public function pImage(){
      return $this->hasOne(ProductImage::class, 'product_id','product_id');
  }

  public function UserDetails(){
      return $this->hasOne(User::class, 'id','user_id');
  }

  public function Product(){
      return $this->hasOne(Product::class, 'id','product_id');
  }

    static function AddAndUpdateReview($request){
            if($request->review_id > 0){
               $Review = Product_review::find($request->review_id);
            }else{
                $Review = new Product_review();
            }
         $Review->user_id = Auth::user()->id;
         $Review->product_id = $request->product_id;
         $Review->order_id = $request->order_id;
         $Review->star = $request->star;
         $Review->heading	= $request->heading;
         $Review->description = $request->description;
         $Review->status = 'notApproved';

         $Review->save();

         return $Review->id;

    }
}
