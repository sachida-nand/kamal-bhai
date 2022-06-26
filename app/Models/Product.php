<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, Sluggable;

    public function PImage(){
        return $this->hasOne(ProductImage::class,'product_id','id');
    }

    public function Review(){
        return $this->hasMany(Product_review::class, 'product_id', 'id');
    }

    protected $fillable = [
        'quantity', 'product_sold'
    ];

    public function Sluggable(): array
    { {
            return [
                'slug' => [
                    'sourse' => 'product_name'
                ]
            ];
        }
    }

    static public function addProductDetails($request)
    {
        if ($request->input('id') > 0) {
            $productModel = Product::find($request->input('id'));
        } else {
            $productModel = new Product();
        }
        $productModel->slug = $request->input('slug');
        $productModel->catagorie_id = $request->input('catagorie');
        $productModel->brand_id = $request->input('brand');
        $productModel->product_name = $request->input('product_name');
        $productModel->minimum_purchage_qty = $request->input('min_purch_qty');
        $productModel->barcode = $request->input('barcode');
        $productModel->refund_day = $request->input('refund_day');
        $productModel->video_link = $request->input('video_link');
        $productModel->unit_price = $request->input('unit_price');
        $productModel->discount = $request->input('discount');
        $productModel->discounted_price = $request->input('discount_price');
        $productModel->discount_type = $request->input('discount_type');
        $productModel->quantity = $request->input('quantity');
        $productModel->sku = $request->input('sku');
        $productModel->product_description = $request->input('description');
        //    $productModel->product_short_description = $request->input('description');
        $productModel->tags = $request->input('tags');
        $productModel->meta_description = $request->input('meta_description');
        $productModel->free_shipping = $request->input('shipping');
        $productModel->shipping_cost = $request->input('shipping_cost');
        $productModel->is_qty_mply = $request->input('is_qty_mply') ? 'yes' : 'no';
        $productModel->stock_warnning = $request->input('stock_warning');
        $productModel->est_shipping_time = $request->input('est_shipping_time');
        $productModel->today_deal = $request->input('today_deal') ? 'yes' : 'no';
        //    $productModel->today_deal_end = $request->input('today_deal_end');
        $productModel->is_featured = $request->input('is_featured') ? 'yes' : 'no';
        $productModel->cash_on_delivery = $request->input('cash_on_delivery') ? 'yes' : 'no';
        $productModel->is_trending = $request->input('is_trending') ? 'yes' : 'no';
        $productModel->status = isset($_POST['publish']) ? 1 : 2;
        // save thubnaim imag 
        if ($request->hasFile('thumbnail_img')) {
            $image = $request->file('thumbnail_img');
            $originalName = $image->getClientOriginalName();
            $newImageName = time() . '-thumb-' . $originalName;

            // remove old image if available 
            if ($productModel->thumbnail_img) {
                unlink(public_path() . '/storage/product_images/' . $productModel->thumbnail_img);
            }
            // upload new image 
            $image->storeAs('/public/product_images', $newImageName);
            $productModel->thumbnail_img = $newImageName;
        }
        $productModel->save();
        return $productModel->id;
    }

    static public function removeThubnailImg($request)
    {
        if ($request->ProductImageId) {
            $ProductImage = Product::find($request->ProductImageId);
            if ($ProductImage->thumbnail_img != '' && file_exists(public_path() . '/storage/product_images/' . $ProductImage->thumbnail_img)) {
                if (unlink(public_path() . '/storage/product_images/' . $ProductImage->thumbnail_img)) {
                    $ProductImage->thumbnail_img = '';
                    $ProductImage->save();
                }
            }
        }
        $status = 'success';
        return $status;
    }

    static public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product->thumbnail_img != null && file_exists(public_path() . '/storage/product_images/' . $product->thumbnail_img)) {
            unlink(public_path() . '/storage/product_images/' . $product->thumbnail_img);
        }
        $product->delete();
        return $product->id;
    }


    static public function GetProducts($Parameter)
    {
        $Products = Product::select('products.id');

        if ($Parameter['id'] && $Parameter['id'] > 0 && $Parameter['type'] == 'catagorie') {
            $Products = $Products->where('products.catagorie_id', $Parameter['id']);
        } else if ($Parameter['id'] && $Parameter['id'] > 0 && $Parameter['type'] == 'brand') {
            $Products = $Products->where('products.brand_id', $Parameter['id']);
        }
        $Products = $Products->where('products.status', 1) // 1 for active or published
            ->join('product_images', 'product_images.product_id', 'products.id')
            ->addSelect('products.*', 'product_images.image')
            ->orderBy('products.id', 'DESC')
            ->groupBy('products.id')
            ->get();
        return $Products;
    }

    static public function GetSingleProduct($Parameter)
    {
        $Products = Product::select('products.id');
        if ($Parameter['type'] == 'singleProduct') {
            $Products = $Products->where('products.slug', $Parameter['slug'])
                ->addSelect('products.*', DB::raw("GROUP_CONCAT(product_images.image SEPARATOR ',') as 'images'"));
        } else if ($Parameter['id'] > 0 && $Parameter['type'] == 'cartProduct') {
            $Products = $Products->where('products.id', $Parameter['id'])
                ->addSelect('products.*', 'product_images.image');
        }
        $Products = $Products->where('products.status', 1) // 1 for active or published
            ->join('product_images', 'product_images.product_id', 'products.id')
            ->groupBy('products.id')
            ->first();
        return $Products;
    }

    static public function updateStatus($id)
    {
    }
}
