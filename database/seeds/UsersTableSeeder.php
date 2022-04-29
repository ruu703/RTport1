<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            // 'nickname' => '',
            // 'profile_img' => '',
            'introduction' => '自己紹介文です。テストテストテスト',
            'delete_flg' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
