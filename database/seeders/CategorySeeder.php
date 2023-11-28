<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Category;


class CategorySeeder extends Seeder
{
    const BASE_ADDRESS = 'D:\OnlineShop\storage\app\public\Demo\\';

    public function addMedia($category, $pictureAddress): void
    {
        $category->addMedia(self::BASE_ADDRESS . $pictureAddress)
//            ->withResponsiveImages()
            ->preservingOriginal()
            ->toMediaCollection('categories');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category1 = Category::create([
//            'id' => '1',
            'name' => 'Phone',
//            'image' => 'Demo/Phone1.jpgg'
        ]);
        $this->addMedia($category1, 'Phone1.jpg');


        $category2 = Category::create([
//            'id' => '2',
            'name' => 'Laptop',
//            'image' => 'Demo/Laptop1.jpgg'
        ]);
        $this->addMedia($category2, 'Laptop1.jpg');


        $category3 = Category::create([
            //'id' => '3',
            'name' => 'Tablet',
//            'image' => 'Demo/Tablet1.jpgg'
        ]);
        $this->addMedia($category3, 'Tablet1.jpg');


        $category4 = Category::create([
            //'id' => '4',
            'name' => 'Smart Watch',
//            'image' => 'Demo/Watch1.jpgg'
        ]);
        $this->addMedia($category4, 'Watch1.jpg');


        $category5 = Category::create([
            //'id' => '5',
            'name' => 'Camera',
//            'image' => 'Demo/Camera1.jpgg'
        ]);
        $this->addMedia($category5, 'Camera1.jpg');


        $category6 = Category::create([
            //'id' => '6',
            'name' => 'Accessory',
//            'image' => 'Demo/Accessory1.jpgg'
        ]);
        $this->addMedia($category6, 'Accessory1.jpg');
    }
}
