<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Event',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Food',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Item',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Travel',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Transportation',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Question',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Other',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->category->insert($categories);//Insert the lists of category to the categories table
    }
}
