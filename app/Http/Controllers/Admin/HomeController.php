<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catagorie;
use App\Models\Product;
use Attribute;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Cviebrock\EloquentSluggable\Services\SlugService;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function setSlug(Request $request)
    {

        if($request->type == 'catagorie'){
            $slug = SlugService::createSlug(Catagorie::class, 'slug', $request->name);
        }

        if($request->type == 'brand'){
            $slug = SlugService::createSlug(Brand::class, 'slug', $request->name);
        }

        if($request->type == 'product'){
            $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        }  
        return response()->json(['slug'=>$slug]);
    }

}
