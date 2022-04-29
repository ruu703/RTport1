<?php

use App\PrivateMessage;
use Illuminate\Database\Seeder;

class PublicMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $privateMessage = factory(PrivateMessage::class, 5)->create();
    }
}
