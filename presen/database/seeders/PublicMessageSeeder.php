<?php

namespace Database\Seeders;

use App\Models\PublicMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $messages = [
            ['user_id' => 1, 'project_id' => 2, 'comment' => 'はじめまして。コメント失礼します。'],
            ['user_id' => 1, 'project_id' => 2, 'comment' => 'この美容室はどこにあるんですか？'],
            ['user_id' => 2, 'project_id' => 2, 'comment' => '全国各地にあります！トータル250店舗あるのでお好きな地域から選択可能です！'],
            ['user_id' => 1, 'project_id' => 2, 'comment' => 'はぇー。'],
        ];

        foreach ($messages as $message) {
            PublicMessage::create($message);
        }
    }
}
