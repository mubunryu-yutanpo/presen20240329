<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = [
            ['name' => '情報提供'],
            ['name' => '案件・依頼'],
            ['name' => '求人'],
            ['name' => 'サービス提供'],
            ['name' => 'その他'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
