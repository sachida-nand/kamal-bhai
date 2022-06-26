<?php

use App\Models\User_address_book;
use Illuminate\Support\Facades\Auth;

  if(!function_exists('createProductUrl')){
      function createProductUrl($strings){
         return str_replace(' ','-',$strings);
      }
  }

  if(!function_exists("userAddress")){
     function userAddress(){
        if (Auth::check()) {
          $userId = Auth::user()->id;
        }
          $Addresses = User_address_book::where('user_id', $userId)->get();
          return $Addresses;
        }
  }

  // if(!function_exists('CalculateSubTotal')){
  //   function CalculateSubTotal($Products, $qty){

  //   }
  // }