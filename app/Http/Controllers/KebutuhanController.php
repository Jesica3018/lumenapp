<?php

namespace App\Http\Controllers;

use App\Models\Kebutuhan;
use stdClass;

class KebutuhanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public function kebutuhan($kategori){
     $api = new \stdClass();
     $kebutuhan = Kebutuhan::where('kategori',$kategori)->get();
     $api->kebutuhan = $kebutuhan;
     return response()->json($api); 
   }
    
    public function detailKebutuhan($id){
     $api = new \stdClass();
     $kebutuhan = Kebutuhan::where('id',$id)->get();
     $api->kebutuhan = $kebutuhan;
     return response()->json($api); 
   }

    //
}
