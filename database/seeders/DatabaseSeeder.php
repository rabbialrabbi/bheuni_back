<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Counselor One',
            'email' => 'counselor1@mail.com',
            'role' => 'counselor',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Counselor Two',
            'email' => 'counselor2@mail.com',
            'role' => 'counselor',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Counselor Three',
            'email' => 'counselor3@mail.com',
            'role' => 'counselor',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Counselor Four',
            'email' => 'counselor4@mail.com',
            'role' => 'counselor',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            LeadSeeder::class,
        ]);
    }
}
