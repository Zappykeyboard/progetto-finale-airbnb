<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
  protected $fillable = [
    'price',
    'name',
    'duration'
  ];

  public function apartaments(){

    return $this -> hasMany(Apartment::class);
  }
}
