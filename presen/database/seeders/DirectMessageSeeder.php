<?php

namespace Database\Seeders;

use App\Models\DirectMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            ['sender_id' => 1, 'chat_id' => 1, 'comment' => '今日はいい天気ですねー。'],
            ['sender_id' => 1, 'chat_id' => 1, 'comment' => 'そちらはどうですか？'],
            ['sender_id' => 2, 'chat_id' => 1, 'comment' => 'こっちは風が強いですわ'],
            ['sender_id' => 1, 'chat_id' => 1, 'comment' => 'ほえー豚ですね。'],
            ['sender_id' => 3, 'chat_id' => 2, 'comment' => 'ほう・・・。'],
            ['sender_id' => 3, 'chat_id' => 2, 'comment' => '貴様がそうか。'],
        ];

        foreach ($messages as $message) {
            DirectMessage::create($message);
        }
    }
}
