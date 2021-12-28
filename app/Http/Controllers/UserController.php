<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use stdClass;

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
    
    public function show($id){
        $listUser = new \stdClass();
        $data2 = DB::table('users')
                ->where('id', $id)->get();
        $listUser->user = $data2;
        return response()->json($listUser); 
    }

    public function ubahDataDiri(Request $request, $id){
        $this->validate($request, [
            'username' => 'required',
            'notelpon' => 'required',
            'alamat' => 'required'
        ]);
        $user = User::where('id', $id)->first();
        $username = $request->input('username');
        $notelpon = $request->input('notelpon');
        $alamat = $request->input('alamat');
        $user->update([
            'username' => $username,
            'notelpon' => $notelpon,
            'alamat' => $alamat
        ]);
        return response()->json(['message' => 'Data diri berhasil diubah']);
    }
}
