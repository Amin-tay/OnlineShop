<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::create([
//            'id' => '1',
            'name' => 'Phone',
            'image' => 'Demo/Phone1.jpg'
        ]);


        Category::create([
//            'id' => '2',
            'name' => 'Laptop',
            'image' => 'Demo/Laptop1.jpg'
        ]);
        Category::create([
            //'id' => '3',
            'name' => 'Tablet',
            'image' => 'Demo/Tablet1.jpg'
        ]);

        Category::create([
            //'id' => '4',
            'name' => 'Smart Watch',
            'image' => 'Demo/Watch1.jpg'
        ]);
        Category::create([
            //'id' => '5',
            'name' => 'Camera',
            'image' => 'Demo/Camera1.jpg'
        ]);
        Category::create([
            //'id' => '6',
            'name' => 'Accessory',
            'image' => 'Demo/Accessory1.jpg'
        ]);
    }
}
