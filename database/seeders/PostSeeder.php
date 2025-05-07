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
        $userIds = range(1, 10); // UserSeederで作成されたユーザーID

        // ランダムに使う画像（public/images に保存されている前提）
        $images = [
            'images/Zinnbei1.png',
            'images/Zinnbei_button.png',
        ];

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
            // Food
            [
                'title' => 'Best Mango Float in Town',
                'description' => 'Where can I find delicious mango float?',
                'category_id' => 2,
                'location' => 'SM Cebu',
            ],
            // Item
            [
                'title' => 'Selling Electric Fan',
                'description' => 'Almost new, 3-speed fan.',
                'category_id' => 3,
                'max' => 3,
            ],

            [
                'title' => 'Selling Electric Fan',
                'description' => 'lets eat ballot for dinner',
                'category_id' => 3,
                'max' => 100,
            ],
            // Travel
            [
                'title' => 'Island Hopping Tour',
                'description' => 'Visit beautiful islands.',
                'category_id' => 4,
                'location' => 'Mactan',
            ],
            // Transportation
            [
                'title' => 'Shared Taxi to Airport',
                'description' => 'Sharing ride to Mactan airport.',
                'category_id' => 5,
                'departure' => 'IT Park',
                'destination' => 'Mactan Airport',
                'fee' => 200,
                'trans_category_id' => 1, // 事前にTransCategorySeederでID=1がある前提
            ],
            // Question
            [
                'title' => 'How to extend visa?',
                'description' => 'Anyone know the latest rule?',
                'category_id' => 6,
                'max' => 30,
            ],
            // Other
            [
                'title' => 'Need study buddy',
                'description' => 'Looking for someone to practice speaking.',
                'category_id' => 7,
            ],
            // 追加
            [
                'title' => 'Dance Party Invitation',
                'description' => 'Join us this weekend!',
                'category_id' => 1,
                'max' => 30,
                'startdatetime' => now()->addDays(5),
                'enddatetime' => now()->addDays(6),
            ],
            [
                'title' => 'Restaurant Recommendations?',
                'description' => 'Where do locals eat?',
                'category_id' => 2,
                'location' => 'Ayala Center',
            ],
            [
                'title' => 'Bus to Moalboal',
                'description' => 'Is there a direct bus?',
                'category_id' => 6,
                'max' => 25,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'user_id' => $faker->randomElement($userIds),
                'title' => $post['title'],
                'description' => $post['description'],
                'category_id' => $post['category_id'],
                'image' => $faker->boolean(50) ? $faker->randomElement($images) : null,
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
