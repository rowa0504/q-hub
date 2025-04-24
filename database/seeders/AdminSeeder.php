
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Add 1 admin User
        $user = new User(); // インスタンスを作成
        $user->name = 'Administrator';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('asdfasdf');
        $user->role_id = User::ADMIN_ROLE_ID; // 修正
        $user->save();
    }
}
