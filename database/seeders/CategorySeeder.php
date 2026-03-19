<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'icon' => 'category/electronics.jpeg',
                'childs' => ['televisions', 'cameras'],
                'description' => 'All kinds of electronic devices and gadgets.',
            ],
            [
                'name' => 'Fashion male',
                'icon' => 'category/fashion-male.jpeg',
                'childs' => ['clothing', 'shoes'],
                'description' => 'Trendy clothing, shoes, and accessories.',
            ],
            [
                'name' => 'fashion female',
                'icon' => 'category/fashion-female.jpeg',
                'childs' => ['clothing', 'shoes'],
                'description' => 'Trendy clothing, shoes, and accessories.',
            ],
            [
                'name' => 'food and drinks',
                'icon' => 'category/fastfood.jpeg',
                'childs' => ['food', 'drinks'],
                'description' => 'Delicious food and refreshing drinks.',

                'name' => 'smartphones',
                'icon' => 'category/handphone.jpeg',
                'childs' => ['android', 'ios'],
                'description' => 'Latest smartphones and accessories.',

                'name' => 'laptops and computers',
                'icon' => 'category/laptops-computers.jpeg',
                'childs' => ['desktops', 'laptops'],
                'description' => 'High-performance laptops and desktop computers.',
            ],
        ];

        foreach ($categories as $categoryPayload) {
            $category = \App\Models\Category::create([
                'slug' => Str::slug($categoryPayload['name']),
                'name' => $categoryPayload['name'],
                'icon' => $categoryPayload['icon'],
                'description' => $categoryPayload['description'],
            ]);

            foreach ($categoryPayload['childs'] as $child) {
                $category->childs()->create([
                    'slug' => Str::slug($child),
                    'name' => $child,
                ]);
            }

        }
    }
}
