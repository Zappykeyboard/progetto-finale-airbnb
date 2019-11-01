<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Feature;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'type'=> $faker-> word
    ];
});
