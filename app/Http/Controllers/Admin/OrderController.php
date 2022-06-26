<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $Orders = Order::orderBy('id','DESC')->get();
        return view('admin.orders',compact('Orders'));
    }
}
