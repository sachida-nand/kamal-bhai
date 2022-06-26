<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class User_address_book extends Model
{
    use HasFactory;

    static public function SaveAddUserAddress($request)
    {
        if(isset($request->address_id) && $request->address_id > 0){
            $Address = User_address_book::find($request->input('address_id'));
        }else{
            $Address = new User_address_book();
        }
        $Address->user_id = Auth::user()->id;
        $Address->full_name = $request->name;
        $Address->mobile = $request->mobile;
        $Address->pincode = $request->pincode;
        $Address->address_one = $request->address_one;
        $Address->address_two = $request->address_two;
        $Address->landmark = $request->landmark;
        $Address->city = $request->city;
        $Address->district = $request->district;
        $Address->address_type = $request->address_type;
        
        $Address->save();

        return $Address->id;
    }

    static public function GetUserAddress($ParaMeter)
    {
        $Address = User_address_book::where('user_id',$ParaMeter['user_id'])
                                     ->where('id', $ParaMeter['address_id'])
                                     ->first();
        return $Address;
    }
}
