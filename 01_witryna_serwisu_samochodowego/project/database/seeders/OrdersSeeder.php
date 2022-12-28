<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'requestID' => 1,
            'employeeID' => 3,
            'startDatetime' => now(),
            'estDuration' => 1,
            'cost' => 50.00,
        ]);
    }
}
