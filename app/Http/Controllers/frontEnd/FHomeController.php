<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catagorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FHomeController extends Controller
{
    public function index()
    {
        $Catagories = Catagorie::where('status',1)
                                ->orderBy('catagorie_name')
                                ->get();
        
        $Brands = Brand::where('status', 1)
                        ->orderBy('brand_name')
                        ->get();
        
        $FeaturedProducts = Product::where('status',1)
                                  ->where('is_featured','yes')
                                  ->get();
        
        $DealOfTheDays = Product::where('status',1)
                                ->where('today_deal','yes')
                                ->get();
        $RecentUploadedProducts = Product::where('status',1)
                                        ->orderBy('id','DESC')
                                        ->get();

        return view('frontEnd.home', 
                    compact(
                        'Catagories',
                        'Brands', 
                        'FeaturedProducts', 
                        'DealOfTheDays', 
                        'RecentUploadedProducts'
                    ));
    }

    public function ByCatagorie($cata_url)
    {   
        $catagorie = Catagorie::where('slug', $cata_url)->first();
        $Search = $catagorie->catagorie_name;

        $ParaMeter['id'] = $catagorie->id;
        $ParaMeter['type'] = 'catagorie';

        $Products = Product::GetProducts($ParaMeter);
        return view('frontEnd.productsItems', compact('Products', 'Search'));
    }

    public function ByBrand($brand_url)
    {
        $Brands = Brand::where('slug', $brand_url)->first();
        $Search = $Brands->brand_name;

        $ParaMeter['id'] = $Brands->id;
        $ParaMeter['type'] = 'brand';
        $Products = Product::GetProducts($ParaMeter);

        return view('frontEnd.productsItems', compact('Products', 'Search'));
    }

    public function DealsAndFeature($url)
    {
        // $string = ;
        $Search = Str::ucfirst(str_replace('-', ' ', $url));
        // dd($Search);
        if($url == 'feature-products'){
            $Products = Product::where('status', 1)
                ->where('is_featured', 'yes')
                ->get();
        }elseif($url == 'deal-of-the-day'){
            $Products = Product::where('status', 1)
                ->where('today_deal', 'yes')
                ->get();
        }else{
           $Product = [];
        }

        return view('frontEnd.productsItems',compact('Products','Search'));
    }

    public function SingleProduct($url)
    {
        $ParaMeter['slug'] = $url;
        $ParaMeter['type'] = 'singleProduct';
        $Product = Product::GetSingleProduct($ParaMeter);

        // dd($Product);

        return view('frontEnd.productDetails', compact('Product'));
    }
}
