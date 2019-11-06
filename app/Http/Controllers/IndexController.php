<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\Feature;

class IndexController extends Controller
{
    public function index(){

      $apts = Apartment::where('active', '1')
                -> inRandomOrder()
                -> take(10)
                -> get();
      $features = Feature::all();
      return view('welcome', compact('apts', 'features'));
    }
}
