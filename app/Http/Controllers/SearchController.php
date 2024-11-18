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
            $result = DB::select("SELECT * FROM movies WHERE title LIKE '%{$input}%' OR locations LIKE '%{$input}%'");
            $movies = json_encode($result);
            return response()->json(['movies'=>$movies]);
    }
    
    
}
