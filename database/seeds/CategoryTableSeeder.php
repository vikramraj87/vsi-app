<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        // Id - 1
        Category::create([
            'category'  => 'Histopathology',
            'parent_id' => null
        ]);

        // Id - 2
        Category::create([
            'category'  => 'Hematopathology',
            'parent_id' => null
        ]);

        // Id - 3
        Category::create([
            'category'  => 'Cytopathology',
            'parent_id' => null
        ]);

        // Id - 4
        Category::create([
            'category'  => 'Blood vessels',
            'parent_id' => 1
        ]);

        // Id - 5
        Category::create([
            'category'  => 'Neoplasms',
            'parent_id' => 4
        ]);

        // Id - 6
        Category::create([
            'category'  => 'Intermediate Malignancy',
            'parent_id' => 5
        ]);

        // Id - 7
        Category::create([
            'category'  => 'Kaposi Sarcoma',
            'parent_id' => 6
        ]);
    }
} 