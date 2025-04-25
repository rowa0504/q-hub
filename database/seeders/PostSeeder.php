<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
                    'name' => 'food',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'tavel',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'question',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'event',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'trnsportation',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'item',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ],
                [
                    'name' => 'other',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]

            ];
    
            $this->trans_category->insert($trans_categories);//Insert the lists of category to the categories table
        }
    
    }
}
