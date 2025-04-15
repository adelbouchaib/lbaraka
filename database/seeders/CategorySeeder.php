<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Home appliance',
            'Automobile accessories',
            'Bags',
            'Beauty',
            'Fashion',
            'Garden',
            'Health care',
            'Home decoration',
            'Jewelry and watches',
            'Kids',
            'Kitchen',
            'Packaging',
            'Pets articles',
            'Shoes',
            'Sports equipment',
            'Tools',
            'Toys'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
