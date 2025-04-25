<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'masahiro',
                'email' => 'masahiro@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'hanako',
                'email' => 'hanako@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'hayato',
                'email' => 'hayato@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'mai',
                'email' => 'mai@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'riki',
                'email' => 'riki@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'rui',
                'email' => 'rui@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'mikuru',
                'email' => 'mikuru@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'ayaka',
                'email' => 'ayaka@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'kai',
                'email' => 'kai@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'teru',
                'email' => 'teru@gmail.com',
                'password' => Hash::make('19981998'),
                'role_id' => user::USER_ROLE_ID,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->user->insert($users);
    }
}
