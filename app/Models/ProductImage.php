<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    static public function addProductImage($request)
    {
        if($request->hasFile('Product_img') && $request->product_images != null)
        {
            $images = $request->file('Product_img');
            foreach($images as $image){
                if(in_array($image->getClientOriginalName(), $request->product_images))
                {
                    $newImageName = time() .'-'. $image->getClientOriginalName();
                    if($image->storeAs('/public/product_images', $newImageName))
                    {
                        $model = new ProductImage();
                        $model->product_id = $request->product_id;
                        $model->image = $newImageName;
                        $model->save();
                    }
                }
            }
        }
    }

    static public function getImages($id)
    {
        $productImages = ProductImage::select('product_images.id')
                            ->addSelect('product_images.*')
                            ->where('product_images.product_id',$id)
                            ->get();
        return $productImages;
    }
    // remove single product image using ajax 
    static public function removeGalleryImg($request)
    {
        if ($request->ProductImageId) {
            $ProductImage = ProductImage::find($request->ProductImageId);
            if ($ProductImage->image != '' && file_exists(public_path() . '/storage/product_images/' . $ProductImage->image)) 
            {
                if (unlink(public_path() . '/storage/product_images/' . $ProductImage->image))
                {
                    $ProductImage->delete();
                }
            }
        }
        $status = 'success';
        return $status;
    }

    // Delete all image after delete the product 
    static public function deleteProductImages($id){
        $images = ProductImage::select('product_images.id')
                               ->addSelect('product_images.*')
                               ->where('product_images.product_id',$id)
                               ->get();

        if(!empty($images))
        {
            foreach ($images as $image) {
                if ($image->image != '' && file_exists(public_path() . '/storage/product_images/' . $image->image)) {
                   unlink(public_path() . '/storage/product_images/' . $image->image);
                }
            }
        }
        return 1;
    }
}
