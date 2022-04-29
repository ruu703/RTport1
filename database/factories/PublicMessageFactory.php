<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PublicMessage;
use Faker\Generator as Faker;

$factory->define(PublicMessage::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'project_id' => 14,

    ];
});
