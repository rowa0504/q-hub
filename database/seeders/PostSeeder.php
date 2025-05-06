<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create(); // Fakerインスタンス作成
        $userIds = range(1, 10); // ユーザーID: 1〜10

        $posts = [
            [
                'title' => 'Music Festival in Cebu',
                'description' => 'Enjoy live performances!',
                'category_id' => 1,
                'max' => 50,
                'startdatetime' => now()->addDays(2),
                'enddatetime' => now()->addDays(3),
            ],
            [
                'title' => 'Island Hopping Tour',
                'description' => 'Visit beautiful islands.',
                'category_id' => 2,
                'location' => 'Mactan',
            ],
            [
                'title' => 'How to extend visa?',
                'description' => 'Anyone know the latest rule?',
                'category_id' => 3,
                'max' => 30,
            ],
            [
                'title' => 'Best Mango Float in Town',
                'description' => 'Where can I find delicious mango float?',
                'category_id' => 4,
                'location' => 'SM Cebu',
            ],
            [
                'title' => 'Shared Taxi to Airport',
                'description' => 'Sharing ride to Mactan airport.',
                'category_id' => 5,
                'departure' => 'IT Park',
                'destination' => 'Mactan Airport',
                'fee' => 200,
                'trans_category_id' => 1,
            ],
            [
                'title' => 'Selling Electric Fan',
                'description' => 'Almost new, 3-speed fan.',
                'category_id' => 6,
            ],
            [
                'title' => 'Need study buddy',
                'description' => 'Looking for someone to practice speaking.',
                'category_id' => 7,
            ],
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
                'category_id' => 4,
                'location' => 'Ayala Center',
            ],
            [
                'title' => 'Bus to Moalboal',
                'description' => 'Is there a direct bus?',
                'category_id' => 3,
                'max' => 30,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'description' => $post['description'],
                'category_id' => $post['category_id'],
                'user_id' => $faker->randomElement($userIds),
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
