<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\ApartmentFeature;

$factory->define(ApartmentFeature::class, function (Faker $faker) {
    return [
        'apartment_id',
        'feature_id'
    ];
});
