<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

use App\User;
use App\Resolution;

$factory->define(Resolution::class, function (Faker $faker) {
    return [
        "user_id" => factory(User::class)->create()->id,
        "title" => $faker->sentence(),
        "description" => $faker->paragraph(),
        "completed" => 1,
        "deadline" => now()->addDays(90)->toDateString()
    ];
});
