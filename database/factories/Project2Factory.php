<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->state(Project::class, 'Project2', function (Faker $faker) {
    return [
        'title' => $faker->realText(20),
        'category_id' => 2,
        'fee_low' => $faker->numberBetween(5,15),
        'fee_high' => $faker->numberBetween(16,30),
        'detail' => $faker->realText(),
        'order_user_id' => function () {
            return factory(App\User::class)->create()->id;
            },
        'received_user_id' => function () {
            return factory(App\User::class)->create()->id;
            },
        'close_flg' => 0,
        'delete_flg' =>  0,
        'created_at' => date('Y-m-d H:i:s')
    ];
});
