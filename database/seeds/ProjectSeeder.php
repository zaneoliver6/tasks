<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name'   => 'Project 1',
        ]);

        DB::table('projects')->insert([
            'name'   => 'Project 2',
        ]);

        DB::table('projects')->insert([
            'name'   => 'Project 3',
        ]);
    }
}
