<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ApartmentRequest;
use GuzzleHttp\Client;


class ApartmentController extends Controller
{
    //funzione per calcolare la distanza tra due punti
    public function getDistance($lat1, $lon1, $apartment){
      $lat2 = $apartment['lat'];
      $lon2 = $apartment['lon'];

      if($lat1 == $lat2 && $lon1 == $lon2){return 0;}

      $p1 = deg2rad($lat1);
      $p2 = deg2rad($lat2);
      $dp = deg2rad($lat2 - $lat1);
      $dl = deg2rad($lon2 - $lon1);
      $a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
      $c = 2 * atan2(sqrt($a),sqrt(1-$a));
      $r = 6371008;
      $d = $r * $c;
      return $d/1000;
    }

    /**
    * Chiede a TomTom latitudine, longitudine e mappa
    * richiede array
    * restituisce array
    */
    public function getMapData($validatedApt){

    //Recupera coordinate e mappa
    $apiKey = env('TOMTOM_APIKEY');

    $tomtom = new Client(['base_uri' => 'https://api.tomtom.com']);

    $response = $tomtom->request('GET',
                                '/search/2/geocode/'. $validatedApt['address'] . '.json',
                                [
                                  'query'=> [
                                    'key'=>$apiKey,
                                    'extendedPostalCodesFor'=>'PAD',
                                    'limit'=>'1'
                                    ]
                                  ]);
    $body = json_decode($response->getBody(), true);

    if ( $body['results']){
          //recupero lat e lon
          $positions = $body['results'][0]['position'];
          $lat = $positions['lat'];
          $lon = $positions['lon'];
          $validatedApt['lat'] = $lat;
          $validatedApt['lon'] = $lon;


          //recupero la mappa
          $response = $tomtom->request('GET',
                                        '/map/1/staticimage',
                                        [
                                          'query' => [
                                            'key'=>$apiKey,
                                            'layer' => 'hybrid',
                                            'style' => 'main',
                                            'format' => 'png',
                                            'zoom' => '17',
                                            'center' => $lon.', '.$lat,
                                            'width' => '512',
                                            'height' => '512',
                                            'view' => 'Unified',
                                          ]
                                        ]);

        $fileName =  "map-" . uniqid() .".png";

        file_put_contents('img/'. $fileName, $response->getBody()->getContents());

        $validatedApt['map_img_path']=$fileName;

    }

      return ($validatedApt);
  }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validated = $request->validate([
          'beds'=> 'required|numeric|min:1',
          'bathrooms'=>'required|numeric|min:1',
          'rooms'=> 'required|numeric|min:1'
        ]);

        $foundApts = new Apartment;

        //cerco solo appartamenti attivi
        $foundApts = $foundApts->where('active','>','0');

        //ciclo i valori della request
        foreach ($validated as $key => $value) {
            $foundApts = $foundApts->where($key, '>=', $value);
        }

        //se sono state selezionate features...
        if($request->features){
          //...cicla e filtra gli appartamenti
          foreach ($request->features as $featID){
            $foundApts = $foundApts->whereHas('features', function(Builder $query) use($featID){
              $query->where('features.id', $featID);
            });
          }
        }


        $foundApts = $foundApts -> get();

        //trovo la distanza tra appartamenti
        if($request->lat && $request->lon){
          $lat = $request->lat;
          $lon = $request->lon;
          $list=[];
          foreach ($foundApts as $index=>$apt) {

            if ($this->getDistance($lat, $lon, $apt->toArray()) <= 20 ){
               $list[] = $apt;

             }
          }
          //ritorna pagina con $list
        }


        dd($list);
        //ritorna pagina con $foundApts

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

        return view('aptcreate_address', compact('features'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        dd($request);
        $validatedApt = $request->validated();

        $validatedApt = $this->getMapData($validatedApt);


        $validatedApt['user_id'] = $request -> user() -> id;
        $validatedApt['visualizations'] = 0;

        //aggiungo la path per l'immagine
        $file = $request -> file('img');

        if ($file) {

          $targetPath = 'img/uploads';
          $targetFile = 'apt-' . uniqid() . "." . $file->getClientOriginalExtension();

          $file->move($targetPath, $targetFile);
            $validatedApt['img_path']=$targetFile;
        }

        //creo la nuova entità sul db
        $newApt = Apartment::create($validatedApt);

        if($request->feature){
          //associo le features all'appartamento
          foreach ($request->feature as $feature) {

            $item = Feature::findOrFail($feature);

            $item -> apartments() -> attach($newApt);
          }
        }

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

        //aggiorno le visualizzazioni

        //genero una chiave per l'appartamento
        $key = "apt" . $id;
        //se la chiave non esiste per questa sessione...
        if (!session()->exists($key)){
          //...aggiorno il campo
          $apt->update([
            'visualizations'=> $apt->visualizations += 1
          ]);
          //e salvo la chiave come visitata
          session([$key=>'visited']);
        }


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

        $apt = Apartment::findOrFail($id);
        $features = Feature::all();

        if ($apt->user_id == Auth::id()) {
          return view('aptedit', compact('apt', 'features'));

        } else {
          return redirect('/');
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, $id)
    {
      $validatedApt = $request->validated();
      //dd($validatedApt);
      $apt = Apartment::findOrFail($id);

      //Solo il proprietario ha il permesso di modificare l'appartmaneto
      if ($apt->user_id == Auth::id()) {

          //se l'indirizzo è cambiato, recuperiamo di nuovo coordinate e mappa
          if($apt->address != $validatedApt["address"]){
            $validatedApt = $this->getMapData($validatedApt);
          }

        //aggiungo la path per l'immagine
        $file = $request -> file('img');

        if ($file) {

          $targetPath = 'img/uploads';
          $targetFile = 'apt-' . uniqid() . "." . $file->getClientOriginalExtension();

          $file->move($targetPath, $targetFile);

          $apt -> update([
            'img_path'=>$targetFile
          ]);
        }

        $apt->features()->detach();
        //controllo se esistono feature nella request
        if($request->feature){

          //associo le features all'appartamento
          foreach ($request->feature as $feature) {

            $item = Feature::findOrFail($feature);

            //sync() aggiorna apartment_feature senza aggiungere duplicati
            $item -> apartments() -> sync($apt,false);

          }
        }

        $apt->update($validatedApt);

        return redirect('/home');

      } else {
        return redirect('/');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apt = Apartment::findOrFail($id);

        if ($apt->user_id == Auth::id()){
          $apt->delete();
          return redirect('/home');

        } else {

          return redirect('/');

        }

    }
}
