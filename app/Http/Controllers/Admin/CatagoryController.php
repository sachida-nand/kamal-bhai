<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catagorie;

class CatagoryController extends Controller
{
    public function index($id = 0)
    {
         if($id > 0){
           $Catagorie = array(Catagorie::find($id));
            $Mode =  'update';
         }else{
            $Catagorie = Catagorie::all();
            $Mode =  '';
         } 
        return view('admin.catagorie', compact('Catagorie','Mode'));
    }

    public function manageCatagorie(Request $request)
    {
        
        $request->validate([
            'catagorie_name' => 'required|unique:catagories,catagorie_name,' . $request->input('id'),
            'slug' => 'required|unique:catagories,slug,' . $request->input('id'),
            'catagorie_logo' => 'mimes:png,jpg,jpeg',
        ]);

        if($request->input('id') > 0){
            $model = Catagorie::find($request->input('id'));
            $msg = "Catagorie Updated";
        }else{
            $model = new Catagorie();
            $msg = "Catagorie inserted successfull";
        }

        if ($request->hasFile('catagorie_logo')) {
            $image = $request->file('catagorie_logo');
            $originalName = $image->getClientOriginalName();
            $newImageName = time() . '-' . $originalName;
             
            // remove old image if available 
            if ($model->catagorie_logo) {
                unlink(public_path() . '/storage/media/' . $model->catagorie_logo);
            }
            // upload new image 
            $image->storeAs('/public/media',$newImageName);
            $model->catagorie_logo = $newImageName;
        }

        $model->catagorie_name = $request->input('catagorie_name');
        $model->slug = $request->slug;
        $model->status = 1;
        $model->save();
       
        return  redirect('catagorie')->with('msg',$msg);
    }

    public function changeStatusOfTheCatagory($type,$operation,$id)
    {
        if($type == 'status' && $operation == 'active'){
            $status = 0;
        }else{
            $status = 1;
        }
        $ChangeStatus = Catagorie::find($id);
        $ChangeStatus->status = $status;
        $ChangeStatus->save();

        return redirect('catagorie');
    }

    public function removeCatagorieImage(Request $request){
        if($request->catagorieImageId){
            $CatagorieDetails = Catagorie::find($request->catagorieImageId);
            
            if($CatagorieDetails->catagorie_logo != '' && file_exists( public_path() . '/storage/media/'. $CatagorieDetails->catagorie_logo))
             {
                unlink(public_path() . '/storage/media/' . $CatagorieDetails->catagorie_logo);
             }
           $CatagorieDetails->catagorie_logo = '';
           $delete = $CatagorieDetails->save();
           if($delete){
              $status = 'success';
           }
        }
        return json_encode(["status"=>$status]);
    }

    public function deleteCatagorie($id)
    { 
        $delete = Catagorie::find($id);
        if ($delete->catagorie_logo) {
            unlink(public_path() . '/storage/media/' . $delete->catagorie_logo);
        }
        $delete->delete();
        return redirect('catagorie')->with('msg','Item deleted');
    }
 
}
