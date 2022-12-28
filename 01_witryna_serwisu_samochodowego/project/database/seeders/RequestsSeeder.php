<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('requests')->insert([
            'clientID' => 2,
            'title' => 'Wymiana opon',
            'model' => 'Passat',
            'description' => 'Lorem ipsum',
            'date' => now(),
            'status' => 1,
        ]);
    }
}
