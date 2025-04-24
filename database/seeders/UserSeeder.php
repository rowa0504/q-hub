<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User; // ← これ追加するの大事！

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'masahiro',
                'email' => 'masahiro@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'hanako',
                'email' => 'hanako@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'hayato',
                'email' => 'hayato@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'mai',
                'email' => 'mai@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'riki',
                'email' => 'riki@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'rui',
                'email' => 'rui@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'mikuru',
                'email' => 'mikuru@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'ayaka',
                'email' => 'ayaka@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'kai',
                'email' => 'kai@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'teru',
                'email' => 'teru@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => User::USER_ROLE_ID, // 修正
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // 修正
        User::insert($users); // $this->user は未定義なので、User::insert に変更
    }
}
