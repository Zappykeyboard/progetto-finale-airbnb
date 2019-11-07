<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $fillable = [

    'expiration_date',
    'tier_id'
  ];

  public function tier(){

    return $this -> belongsTo(Tier::class);
  }

  public function apartment(){

    return $this -> belongsTo(Apartment::class);
  }

  public function user(){

    return $this -> belongsTo(User::class);
  }
}
