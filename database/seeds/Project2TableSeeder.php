<?php

use App\Project;
use Illuminate\Database\Seeder;

class Project2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = factory(Project::class, 20) ->states('Project2')->create();
    }
}
