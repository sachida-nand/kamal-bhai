<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;

    public function ProductImage(){
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
    }

    public function ProductDetails(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
