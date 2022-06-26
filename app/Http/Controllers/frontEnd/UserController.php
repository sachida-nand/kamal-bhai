<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_address_book;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index($id = 0)
    {
        $Address = [];
        if ($id > 0) {
            $Address = User_address_book::find($id);
        }
        return view('frontEnd.addUserAddress', compact('Address'));
    }

    public function LoginAndSecurity($url_type)
    {
        if ($url_type == 'change_name' || $url_type == 'change_password' || $url_type == 'change_phone' || $url_type == 'change_email') {
            $Parameter['url_type'] = $url_type;

            return view('frontEnd.ChangeLoginCredential', compact('Parameter'));
        } else {
            return view('frontEnd.loginAndSecurity')->with('msg', 'There\'s a problem on changing your request.');
        }
    }

    public function UpdateUserDetails(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (isset($request->name)) {
            $request->validate([
                'name' => 'required|string'
            ]);
            $user->name = $request->post('name');
            $Parameter['url_type'] = 'change_name';
        }

        if (isset($request->email)) {
            $Parameter['url_type'] = 'change_email';

            $request->validate([
                'email' => 'required|email|unique:users,email,' . $user->id
            ]);
            $user->email = $request->post('email');
        }

        if (isset($request->mobile)) {
            $Parameter['url_type'] = 'change_phone';
            $request->validate([
                'mobile' => 'required|numeric|digits:10|unique:users,phone,' . $user->id,
            ]);
            $user->phone = $request->post('mobile');
        }

        if (isset($request->password)) {

            $Parameter['url_type'] = 'change_password';
            $OldPassword = $request->post('old_password');
            $NewPassword = $request->post('password');
            $ConfirmPassword = $request->post('confirm_password');

            if (Hash::check($OldPassword, $user->password)) {
                $val =  $request->validate([
                    'password' => 'required|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'
                ]);

                if ($NewPassword == $ConfirmPassword) {
                    $user->password = Hash::make($NewPassword);
                } else {
                    $error = 'Password not matched';
                }
            } else {
                $error = 'You entered wrong password';
            }
        }

        $user->save();
        $msg = 'Success';

        if (isset($error)) {
            return view('frontEnd.ChangeLoginCredential', compact('Parameter'))->with('error', $error);
        } else {
            return redirect('login-and-security')->with('success', $msg);
        }
    }

    public function UpdateProfilePicAjax(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (isset($request->user_Profile)) {
            $request->validate([
                'user_Profile' => 'required|mimes:png,jpg,jpeg|max:2097152', //2mb
            ]);

            $image = $request->file('user_Profile');
            $imageExtension = $image->getClientOriginalExtension();

            $newImageName = time() . '-' . Str::uuid() . '.' . $imageExtension;

            if ($user->image) {
                unlink(public_path() . '/storage/userprofile/' . $user->image);
            }
            
            $image->storeAs('/public/userprofile', $newImageName);
            $user->image = $newImageName;
            $user->save();
            $status = 'Success';
        }
        return json_encode(['Status' => $status]);
    }

    public function AddNewAddress(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric',
            'city' => 'required',
            'address_one' => 'required',
            'district' => 'required',
            'address_type' => 'required',
        ]);

        if ($request->address_id > 0) {
            $msg = 'Your Address has been updated successfully';
        } else {
            $msg = 'Your Address has been added successfully';
        }

        try {
            User_address_book::SaveAddUserAddress($request);
        } catch (\Throwable $th) {
            $msg = 'Your request is not done' . $th->getMessage();
        }
        return redirect('your-address')->with('msg', $msg);
    }

    public function AddNewAddressAjax(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric',
            'city' => 'required',
            'address_one' => 'required',
            'district' => 'required',
            'address_type' => 'required',
        ]);

        try {
            $Address = User_address_book::SaveAddUserAddress($request);

            if ($Address) {
                $msg = 'Address Added';
                $status = 'success';
            }
        } catch (\Throwable $th) {
            $msg = 'Address not Added' . $th->getMessage();
            $status = 'error';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function RemoveAddressAjax(Request $request){
        $AddressId = $request->AddressId;

        $delete = User_address_book::find($AddressId)->delete();
        
        if($delete){
            $Status = 'Success';
        }else{
            $Status = 'Fail';
        }
        return json_encode(['Status' => $Status]);
    }
}
