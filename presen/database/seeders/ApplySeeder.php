<?php

namespace Database\Seeders;

use App\Models\Apply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $applies = [
            ['user_id' => 1, 'project_id' => 2],
            ['user_id' => 3, 'project_id' => 2],
            ['user_id' => 2, 'project_id' => 5],
            ['user_id' => 2, 'project_id' => 4],

        ];

        foreach ($applies as $apply) {
            Apply::create($apply);
        }
    }
}
