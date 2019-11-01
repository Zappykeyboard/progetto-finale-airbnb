<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Apartament;

class Feature extends Model
{
  protected $fillable = [
    'type'
  ];

  public function apartments(){

    return $this -> belongsToMany(Apartment::class);
  }

}
