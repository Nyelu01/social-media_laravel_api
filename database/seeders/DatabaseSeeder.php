<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Myelu Mwamkinga',
            'email' => 'nyeluog@gmail.com',
            'mobile' => '0789675456',
            'password' => Hash::make('nyelu123')

        ]);
    }
}
