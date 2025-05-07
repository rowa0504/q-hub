<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Post;
use Faker\Factory as Faker;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // category_id = 6 (Questions) の投稿一覧を取得
        $questionPosts = Post::where('category_id', 6)->pluck('id')->toArray();

        if (empty($questionPosts)) {
            echo "No question posts found. Please run PostSeeder first.\n";
            return;
        }

        foreach ($questionPosts as $postId) {
            for ($i = 0; $i < 3; $i++) { // 各質問に対して3つずつアンサー生成
                Answer::create([
                    'body' => $faker->sentence(rand(4, 10)),
                    'user_id' => rand(1, 10), // 適当なユーザーID範囲
                    'post_id' => $postId,
                    'created_at' => now()->subMinutes(rand(1, 60)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
