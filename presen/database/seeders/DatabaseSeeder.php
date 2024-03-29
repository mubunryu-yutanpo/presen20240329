<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DirectMessage;
use App\Models\Project;
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
        //     'email' => 'section@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            TypeSeeder::class,
            ProjectSeeder::class,
            PublicMessageSeeder::class,
            ApplySeeder::class,
            ChatSeeder::class,
            DirectMessageSeeder::class,
        ]);
    }
}
