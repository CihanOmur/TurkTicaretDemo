<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'color' => '#FF5733'],
            ['name' => 'Personal', 'color' => '#33FF57'],
            ['name' => 'Urgent', 'color' => '#3357FF'],
            ['name' => 'Shopping', 'color' => '#FF33A1'],
            ['name' => 'Travel', 'color' => '#A133FF'],
        ];

        foreach ($categories as $category) {
            $newCategory = new \App\Models\Category();
            $newCategory->name = $category['name'];
            $newCategory->color = $category['color'];
            $newCategory->save();
        }
    }
}
