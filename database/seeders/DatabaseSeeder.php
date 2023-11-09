<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = new User([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$GcMCetLNqwxHAueZMnjXl.wKTlpuqWxwKR7gUS5bkU0hVrgTmzNDG',
            'created_at' => '2023-10-12 14:17:02',
            'updated_at' => '2023-10-12 14:17:02',
        ]);
        $user->save();
    }
}