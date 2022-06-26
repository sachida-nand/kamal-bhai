<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Product_review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $Reviews = Product_review::where('user_id',$userId)->where('status', 'approved')->get();
        return view('frontEnd.productReviewShow',compact('Reviews'));
    }

    public function ProductReview($Product_slug, $Order_id){
        $Parameter['type'] = 'singleProduct';
        $Parameter['slug'] = $Product_slug;
        $Product = Product::GetSingleProduct($Parameter);
        $Order = Order::where('order_id',$Order_id)->first();

        $Review = Product_review::Where('product_id',$Product->id)
                                ->where('order_id',$Order->order_id)
                                ->first();

        if(!$Product || $Order == null){
            return 'echo nhi mila';
        }
        return view('frontEnd.writeProductReview',compact('Product','Order','Review'));
    }

    public function ManageProductReview(Request $request){

        $Review = Product_review::AddAndUpdateReview($request);
        
        return 'Review submitted - Thank you! We are processing your review. This might take several days, so we appreciate your patience. We will email you when this is complete.';
    }

    public function DeleteReview($review_id){
      $delete =  Product_review::find($review_id)->delete();
      if($delete)
      {
          $Status = 'Success';
          $msg = 'You successfully removed your review!';
      }else{
          $Status = 'Error';
          $msg = 'There\'s a problem on removing your request.';
      }
        return redirect('product-review')->with(['msg'=>$msg,'status'=>$Status]);
    }
}
