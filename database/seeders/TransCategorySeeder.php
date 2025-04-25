<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransCategory;

class TransCategorySeeder extends Seeder
{
    private $trans_category;

    public function __construct(TransCategory $trans_category){
        $this->trans_category = $trans_category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trans_categories = [
            [
                'name' => 'Bike',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Taxi',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Jeepney',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->trans_category->insert($trans_categories);//Insert the lists of category to the categories table
    }
}
