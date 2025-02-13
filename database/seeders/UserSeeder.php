<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {


        User::create([
            'username' => 'parent1',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'parent',
        ]);

        User::create([
            'username' => 'parent2',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'parent',
        ]);

        User::create([
            'username' => 'parent3',
            'email' => 'parent3@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'parent',
        ]);

        User::create([
            'username' => 'parent4',
            'email' => 'parent4@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'parent',
        ]);
    }
}
