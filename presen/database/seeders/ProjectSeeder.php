<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $projects = [
            ['user_id' => 1, 'title' => '未経験からエンジニア！', 'type_id' => 1, 'price' => 40000, 'content' => 'あなたも未経験からエンジニアになれますよ！', 'thumbnail' => 'uploads/image15.png'],
            ['user_id' => 2, 'title' => '【急募！】ヘアサロンスタッフ', 'type_id' => 3, 'price' => 0, 'content' => '人気ヘアサロンの新規スタッフを募集中！未経験OK！', 'thumbnail' => 'uploads/image16.png'],
            ['user_id' => 2, 'title' => '安心の正社員！充実の福利厚生！', 'type_id' => 3, 'price' => 0, 'content' => 'アットホームな職場です！もし時間内に仕事が終わらなくても、みんなで慈善的に手伝います！お盆と正月は社員旅行があります！', 'thumbnail' => 'uploads/image17.png'],
            ['user_id' => 3, 'title' => '子供たちとの環境をより便利に', 'type_id' => 2, 'price' => 300000, 'content' => '当園のDX化にご協力くださるエンジニアの方を募集します。', 'thumbnail' => 'uploads/image11.png'],
            ['user_id' => 3, 'title' => '経営改善と業務効率化のご相談', 'type_id' => 2, 'price' => 50000, 'content' => '経営不振のバーを盛り上げるためのアイデアや業務効率化に協力いただける方を募集します', 'thumbnail' => 'uploads/image14.png'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
