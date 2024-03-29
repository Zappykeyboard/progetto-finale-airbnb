<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $fillable = [

    'apartment_id'
  ];

  public function apartment(){

    return $this -> belongsTo(Apartment::class);
  }


}
