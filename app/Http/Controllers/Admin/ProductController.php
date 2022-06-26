<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagorie;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id = 0)
    {
        if ($id > 0)
        {
            $Products = array(Product::find($id));
            $Mode =  'update';
        } else {
            $Products = Product::all();
            $Mode =  '';
        }
       $Catagories = DB::table('catagories')
                        ->where('status', '=', '1')
                        ->get();
       $Brands = DB::table('brands')
                        ->where('status', '=', '1')
                        ->get();
       $ProductImages = ProductImage::getImages($id);

       return view('admin.product', compact('Products','Mode','Catagories','Brands', 'ProductImages'));
    }

    public function manageProduct(Request $request)
    {  
         
        $request->validate([
            // 'slug' => 'required|unique:products, slug,' . $request->input('id')
            'slug' => 'required|unique:products,slug,' . $request->input('id'),
        ]);

        if ($request->input('id') > 0)
        {
            $msg = "Product Updated successfull";
        } else {
            $msg = "Product inserted successfull";
        }
        $productId =  Product::addProductDetails($request);

        if($productId)
        {
            $request['product_id'] = $productId;
            ProductImage::addProductImage($request);
        }
        return  redirect('product')->with('msg', $msg);
    }

    public function removeProductImageAjax(Request $request)
    {  
        if($request->ImageType == 'thumbnail')
        {
            $status =   Product::removeThubnailImg($request);
        } else if($request->ImageType == 'gallery')
        {
            $status = ProductImage::removeGalleryImg($request);
        }
        return json_encode(["status" => $status]);
    }

    public function deleteProduct($id)
    {
        try {
            $ImageDeleted =  ProductImage::deleteProductImages($id);
            if ($ImageDeleted) {
                Product::deleteProduct($id);
            }
            $msg = 'Product item deleted';
        } catch (\Throwable $th) {
            $msg = 'Product item Not deleted '.$th->getMessage();
        }
        
        return redirect('product')->with('msg', $msg);
    }

    public function changeIsFeaturedStatus(Request $request)
    {
          $productId = $request->productId;
          
         try { 
            $Product = Product::find($productId);
                if ($Product->is_featured == 'yes') 
                {
                    $Status = 'no';
                } else {
                    $Status = 'yes';
                } 
            $Product->is_featured = $Status;
            $Product->save();

            $SaveStatus = 'Success';
            $msg = 'Featured products updated successfully';
         } catch (\Throwable $th) {
            $SaveStatus = 'error';
            $msg = 'Featured products not updated'.$th->getMessage();
         }
          return json_encode(['status' =>$SaveStatus, 'msg'=>$msg]);
    }

    public function changeIsTrendingStatus(Request $request)
    {
        $productId = $request->productId;
        
        try {
            $Product = Product::find($productId);
            if($Product->is_trending == 'yes'){
                $Status = 'no';
            }else{
                $Status = 'yes';
            }
            $Product->is_trending = $Status;
            $Product->save();

            $SaveStatus = 'Success';
            $msg = 'Is trending products updated successfully';
        } catch (\Throwable $th) {
            $SaveStatus = 'error';
            $msg = 'Is trending products not updated' . $th->getMessage();
        }
        return json_encode(['status' => $SaveStatus, 'msg' => $msg]);
    }

    public function changeIsTodayDealStatus(Request $request){
        $productId = $request->productId;

        try {
            $Product = Product::find($productId);
            if($Product->today_deal == 'yes'){
                $Status = 'no';
            }else{
                $Status = 'yes';
            }
            $Product->today_deal = $Status;
            $Product->save();
            $SaveStatus = 'Success';
            $msg = 'Today deal products updated successfully';
        } catch (\Throwable $th) {
            $SaveStatus = 'error';
            $msg = 'Today Deal products not updated' . $th->getMessage();
        }
        return json_encode(['status' => $SaveStatus, 'msg' => $msg]);
    }

    public function changePublishedStatus(Request $request)
    {
       $productId = $request->productId;

       try {
           $Product = Product::find($productId);
           if($Product->status == '1'){
               $Status = '2';
           }else{
               $Status = '1';
           }

            $Product->status = $Status;
            $Product->save();
            $SaveStatus = 'Success';
            $msg = 'Products published successfully';
        } catch (\Throwable $th) {
            $SaveStatus = 'error';
            $msg = 'Products not published' . $th->getMessage();
        }
        return json_encode(['status' => $SaveStatus, 'msg' => $msg]);
    }
}
