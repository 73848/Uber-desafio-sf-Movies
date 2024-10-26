<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){
        $input = $request->validate(['search'=>'required']);
        $result = DB::table('movies')->where('title', $input)->orWhere('locations',$input)->get();
        $resultJson = json_encode($result);
        return $resultJson;
    }
}
