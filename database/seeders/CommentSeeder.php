<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = range(1, 10);
        $postIds = \App\Models\Post::pluck('id')->toArray();

        if (empty($postIds)) {
            echo "No posts found. Please seed posts first.\n";
            return;
        }

        for ($i = 0; $i < 30; $i++) {
            $comment = new Comment();
            $comment->body = $faker->sentence(rand(6, 15));
            $comment->user_id = $faker->randomElement($userIds);
            $comment->post_id = $faker->randomElement($postIds);
            $comment->created_at = now()->subDays(rand(0, 10));
            $comment->updated_at = now();
            $comment->save();
        }
    }
}
