<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'notelpon' => 'required',
            'alamat' => 'required'
        ]);
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $notelpon = $request->input('notelpon');
        $alamat = $request->input('alamat');

        $user = User::create([
            'username' => $username,
            'password' => $password,
            'notelpon' => $notelpon,
            'alamat' => $alamat
        ]);
        
        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);

        $api = new \stdClass();
        $api->register_user = $user;
        return response()->json($api);
    }
    
    public function show(){
        $auth = Auth::user();
        $user = User::where('id',$auth->id)->first();
        $api = new \stdClass();
        $api->detail_user = $user;
        return response()->json($api); 
    }

    public function ubahDataDiri(Request $request){
        $auth = Auth::user();
        
        $username = $request->input('username');
        $notelpon = $request->input('notelpon');
        $alamat = $request->input('alamat');
        
        $user = User::find($auth->id);
        $user->update([
            'username' => $username,
            'notelpon' => $notelpon,
            'alamat' => $alamat
        ]);
        return response()->json(['message' => 'Data diri berhasil diubah']);
    }
    
    public function ubahSandi(Request $request){
        $auth = Auth::user();
        
        $password = Hash::make($request->input('password'));
        
        $user = User::find($auth->id);
        $user->update([
            'password' => $password
        ]);
        return response()->json(['message' => 'Password berhasil diubah']);   
    }
}
