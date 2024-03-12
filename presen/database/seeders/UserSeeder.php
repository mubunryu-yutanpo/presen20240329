<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            ['name' => 'test1', 'email' => 'test@1.com', 'password' => 'password', 'avatar' => '/uploads/image12.png'],
            ['name' => 'test2', 'email' => 'test@2.com', 'password' => 'password', 'avatar' => '/uploads/image13.png'],
            ['name' => 'test3', 'email' => 'test@3.com', 'password' => 'password', 'avatar' => '/uploads/image3.jpeg'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
