<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(20),
        'category_id' => 1,
        'fee_low' => $faker->numberBetween(10000,39000),
        'fee_high' => $faker->numberBetween(40000,100000),
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
