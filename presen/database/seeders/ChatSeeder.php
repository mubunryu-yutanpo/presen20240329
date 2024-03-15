<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = [
            ['user1_id' => 1, 'user2_id' => 2],
            ['user1_id' => 2, 'user2_id' => 3],
            ['user1_id' => 1, 'user2_id' => 3],
        ];

        foreach ($chats as $chat) {
            Chat::create($chat);
        }
    }
}
