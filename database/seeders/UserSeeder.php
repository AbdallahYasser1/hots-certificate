<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@hots.com',
                'password' => 'admin',
            ]);
        }
    }
}
