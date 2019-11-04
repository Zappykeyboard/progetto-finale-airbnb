<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentFeature extends Model
{
  protected $fillable = [
    'apartment_id',
    'feature_id'
  ];
}
