<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'type' => 3,
            'phone' => '987654321',
        ]);

        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('secret'),
            'type' => 1,
            'phone' => '692137420',
        ]);

        DB::table('users')->insert([
            'name' => 'Dohn Joe',
            'email' => 'dohn.joe@gmail.com',
            'password' => bcrypt('secret'),
            'type' => 2,
            'phone' => '123456789',
        ]);


    }
}
