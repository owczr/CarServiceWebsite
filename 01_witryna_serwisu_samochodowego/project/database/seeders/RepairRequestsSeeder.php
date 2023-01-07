<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('repair_requests')->insert([
            'clientID' => 2,
            'title' => 'Wymiana opon',
            'model' => 'Passat',
            'description' => 'Lorem ipsum',
            'date' => now(),
            'status' => 1,
        ]);
        DB::table('repair_requests')->insert([
            'clientID' => 4,
            'title' => 'Wymiana opon',
            'model' => 'Audi A4',
            'description' => 'Lorem ipsum ipsum lorem',
            'date' => now(),
            'status' => 0,
        ]);

        DB::table('repair_requests')->insert([
            'clientID' => 2,
            'title' => 'Wymiana oleju',
            'model' => 'Passat',
            'description' => 'oleooo',
            'date' => now(),
            'status' => 0,
        ]);
    }
}
