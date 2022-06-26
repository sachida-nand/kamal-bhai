<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   static public function GetOrderItems($userId)
    {
        $OrderItems = Order::where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();

        return $OrderItems;
    }

    public function itemDetails(){
        return $this->hasMany(Order_detail::class, 'order_id', 'id');
    }
}
