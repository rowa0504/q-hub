<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = range(1, 10); // UserSeeder で事前に作成されたユーザーID

        $posts = [
            // Event
            [
                'title' => 'Music Festival in Cebu',
                'description' => 'Enjoy live performances!',
                'category_id' => 1,
                'max' => 50,
                'startdatetime' => now()->addDays(2),
                'enddatetime' => now()->addDays(3),
            ],
            // Travel
            [
                'title' => 'Island Hopping Tour',
                'description' => 'Visit beautiful islands.',
                'category_id' => 2,
                'location' => 'Mactan',
            ],
            // Question
            [
                'title' => 'How to extend visa?',
                'description' => 'Anyone know the latest rule?',
                'category_id' => 3,
            ],
            // Food
            [
                'title' => 'Best Mango Float in Town',
                'description' => 'Where can I find delicious mango float?',
                'category_id' => 4,
                'location' => 'SM Cebu',
            ],
            // Transportation
            [
                'title' => 'Shared Taxi to Airport',
                'description' => 'Sharing ride to Mactan airport.',
                'category_id' => 5,
                'departure' => 'IT Park',
                'destination' => 'Mactan Airport',
                'fee' => 200,
                'trans_category_id' => 1, // TransCategorySeeder で ID:1 を作成している前提
            ],
            // Item
            [
                'title' => 'Selling Electric Fan',
                'description' => 'Almost new, 3-speed fan.',
                'category_id' => 6,
            ],
            // Other
            [
                'title' => 'Need study buddy',
                'description' => 'Looking for someone to practice speaking.',
                'category_id' => 7,
            ],
            // 追加のイベント
            [
                'title' => 'Dance Party Invitation',
                'description' => 'Join us this weekend!',
                'category_id' => 1,
                'max' => 30,
                'startdatetime' => now()->addDays(5),
                'enddatetime' => now()->addDays(6),
            ],
            // 食事
            [
                'title' => 'Restaurant Recommendations?',
                'description' => 'Where do locals eat?',
                'category_id' => 4,
                'location' => 'Ayala Center',
            ],
            // 質問
            [
                'title' => 'Bus to Moalboal',
                'description' => 'Is there a direct bus?',
                'category_id' => 3,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'user_id' => $faker->randomElement($userIds),
                'title' => $post['title'],
                'description' => $post['description'],
                'category_id' => $post['category_id'],
                'image' => null,
                'location' => $post['location'] ?? null,
                'departure' => $post['departure'] ?? null,
                'destination' => $post['destination'] ?? null,
                'fee' => $post['fee'] ?? null,
                'max' => $post['max'] ?? null,
                'startdatetime' => $post['startdatetime'] ?? null,
                'enddatetime' => $post['enddatetime'] ?? null,
                'trans_category_id' => $post['trans_category_id'] ?? null,
                'best_answer_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
