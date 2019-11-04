<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;

class SearchPageController extends Controller
{
    public function SearchWithQuery(Request $request){

      $results = Apartment::search($request['query'])->get();

      return view('searchpage', compact('results'));

    }


    public function index(){
      return view('searchpage');
    }
}
