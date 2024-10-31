<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){

            $input = $request->validate(['search'=>'required|string']);
            $input = strip_tags($input['search']);
            $result = Movie::query()->where('title','LIKE',  "%{$input}%")->get();
            $movies = json_encode($result);
            return response()->json(['movies'=>$movies]);
    }
}
