<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index($id = 0)
    {
        if ($id > 0) {
            $Brands = array(Brand::find($id));
            $Mode =  'update';
        } else {
            $Brands = Brand::all();
            $Mode =  '';
        }
        return view('admin.brand', compact('Brands', 'Mode'));
    }

    public function manageBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name,' . $request->input('id'),
            'slug' => 'required|unique:brands,slug,' . $request->input('id'),
            'brand_logo' => 'mimes:png,jpg,jpeg',
        ]);

        if ($request->input('id') > 0) {
            $model = Brand::find($request->input('id'));
            $msg = "Brand Updated";
        } else {
            $model = new Brand();
            $msg = "Brand inserted successfull";
        }

        if ($request->hasFile('brand_logo')) {
            $image = $request->file('brand_logo');
            $originalName = $image->getClientOriginalName();
            $newImageName = time() . '-' . $originalName;

            // remove old image if available 
            if ($model->brand_logo) {
                unlink(public_path() . '/storage/media/' . $model->brand_logo);
            }
            // upload new image 
            $image->storeAs('/public/media', $newImageName);
            $model->brand_logo = $newImageName;
        }

        $model->brand_name = $request->input('brand_name');
        $model->slug = $request->slug;
        $model->status = 1;
        $model->save();

        return  redirect('brand')->with('msg', $msg);
    }

    public function changeStatusOfTheBrand($type, $operation, $id)
    {
        if ($type == 'status' && $operation == 'active') {
            $status = 0;
        } else {
            $status = 1;
        }
        $ChangeStatus = Brand::find($id);
        $ChangeStatus->status = $status;
        $ChangeStatus->save();

        return redirect('brand');
    }

    public function removeBrandImage(Request $request)
    {
        if ($request->brandImageId) {
            $brandDetails = Brand::find($request->brandImageId);
            if ($brandDetails->brand_logo != '' && file_exists(public_path() . '/storage/media/' . $brandDetails->brand_logo)) {
                unlink(public_path() . '/storage/media/' . $brandDetails->brand_logo);
            }
            $brandDetails->brand_logo = '';
            $delete = $brandDetails->save();
            if ($delete) {
                $status = 'success';
            }
        }
        return json_encode(["status" => $status]);
    }

    public function deleteBrand($id)
    {
        $delete = Brand::find($id);
        if ($delete->brand_logo) {
            unlink(public_path() . '/storage/media/' . $delete->brand_logo);
        }
        $delete->delete();
        return redirect('brand')->with('msg', 'Item deleted');
    }
}
