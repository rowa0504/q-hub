<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // ← これ追加するの大事！

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 10人のダミーユーザーを作るよ〜🧚‍♀️
        User::factory()->count(10)->create();
    }
}
