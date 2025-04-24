<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transCategories = [
            ['name' => 'Bike', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Taxi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jeepney', 'created_at' => now(), 'updated_at' => now()],
            
        ];

        DB::table('trans_categories')->insert($transCategories);
    }
}
