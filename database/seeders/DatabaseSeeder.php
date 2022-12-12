<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'instance',
            'password' => bcrypt('password'),
            'role' => 'instance',
        ]);
    }
}
