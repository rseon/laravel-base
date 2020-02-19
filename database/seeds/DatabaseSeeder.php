<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@restau.dv'],
            [
                'name' => 'Admin Is Trator',
                'password' => Hash::make('azertyuiop'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'user@restau.dv'],
            [
                'name' => 'User Basic',
                'password' => Hash::make('azertyuiop'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]
        );

    }
}
