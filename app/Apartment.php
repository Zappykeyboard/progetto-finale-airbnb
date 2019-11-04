<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feature;

class Apartment extends Model
{
  use FullTextSearch;

  protected $searchable = [
    'description',
    'address'
  ];

  protected $fillable = [
    'description',
    'rooms',
    'beds',
    'bathrooms',
    'mq',
    'address',
    'geo_coords',
    'visualizations',
    'active',
    'user_id',
    'tier_id'
  ];

  public function features(){

    return $this -> belongsToMany(Feature::class);
  }

  public function user(){

    return $this -> belongsTo(User::class);
  }

  public function tier(){

    return $this -> belongsTo(Tier::class);
  }

  public function messages(){

    return $this -> belongsToMany(Message::class);
  }
}
