<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username' => 'required|alpha_dash|unique:users,username,'.$user->id,
        ]);

        $model = User::findOrFail($user->id);
        $model->name = $request->name;
        $model->email = $request->email;
        $model->username = $request->username;
        $model->save();

        return redirect()->route('profile.index')
            ->with('success_message', 'Berhasil Mengubah Data Pengguna');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nip' => 'required',
            'golongan' => 'required',
            'jabatan' => 'required',
        ]);
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['nip' => $request->nip, 'golongan' => $request->golongan, 'jabatan'=> $request->jabatan]
        );
        return redirect()->route('profile.index')
            ->with('success_message', 'Berhasil Mengubah Data Profil Pengguna');
    }

    public function uploadFoto(Request $request)
    {
        $user = Auth::user();

        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $image_name= $user->username.'.png';
        $path = public_path() . "/profile/" . $image_name;

        file_put_contents($path, $data);

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['photo' => $image_name]
        );

        return response()->json(['success'=>'done']);
    }

    public function changePasswordView(Request $request)
    {
        return view('profile.change-password');

    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'new-password' => 'required|min:4|confirmed'
        ]);

        $current_password = $request->get('current-password');
        $new_password = $request->get('new-password');
        
        $validator->after(function($validator) use ($current_password, $new_password){
            if(!(Hash::check($current_password, Auth::user()->password))){
                $validator->errors()->add('current-password', 'Your current password does not matches with the password you provided. Please try again.');
            }

            if(strcmp($current_password, $new_password) == 0){
                $validator->errors()->add('new-password', 'New Password cannot be same as your current password. Please choose a different password.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->password = Hash::make($new_password);
        $user->save();

        return redirect()->route('profile.change-password-view')
            ->with('success_message', 'Berhasil mengubah Kata Sandi');

    }
}
