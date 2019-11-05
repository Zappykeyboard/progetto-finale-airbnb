<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\Feature;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $file= $request->file('file');

        $features= Feature::all();
        // File::create([
        //   'title'=> $file-> getClientOriginalName(),
        //   'description' => 'upload whit dropzone.js',
        //   'path' => $file-> store('public/storage')
        //
        // ]);

        return view('aptcreate_address', compact('features'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedApt = $request->validate([
          'description' => 'required',
          'address' => 'required',
          'mq'=> 'required',
          'rooms'=> 'required',
          'beds'=> 'required',
          'bathrooms'=> 'required',
          'img'=> 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:4048'
        ]);

        $validatedApt['user_id'] = $request -> user() -> id;

        $file = $request -> file('img');

        if ($file) {

          $targetPath = 'img';
          $targetFile = rand(1,1000) . "_apt" . $file->getClientOriginalExtension();

          $file->move($targetPath, $targetFile);

          $validatedApt['img_path'] = $targetFile;
        }

        $newApt = Apartment::create($validatedApt);


        $validatedFeatures = $request->validate([
          'feature' => 'nullable'
        ]);


        foreach ($validatedFeatures['feature'] as $feature) {

          $item = Feature::findOrFail($feature);

          $item -> apartments() -> attach($newApt);
        }

        // dd($newAspt);
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apt = Apartment::findOrFail($id);

        return view('aptshow', compact('apt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
