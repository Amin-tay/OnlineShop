<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\app\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const BASE_ADDRESS = 'D:\OnlineShop\storage\app\public\Demo\\';

    public function addMedia($product, $pictureAddress): void
    {
        $product->addMedia(self::BASE_ADDRESS . $pictureAddress)
//            ->withResponsiveImages()
            ->preservingOriginal()
            ->toMediaCollection('products');
    }

    public function run(): void
    {


        $product1 = Product::create([
            'name' => 'Phone 1',
//            'image' => 'Demo/Phone2.jpgg',
            'price' => '1199.99',
            'quantity' => '8',
            'category_id' => '1',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta debitis, architecto iure hic tempore nulla corrupti voluptate? Veniam,
             voluptatibus recusandae deleniti eum aperiam magnam,
              nam accusamus vitae ad officia culpa',
        ]);
        $this->addMedia($product1, 'Phone2.jpg');


        $product2 = Product::create([
            'name' => 'Phone 2',
//            'image' => 'Demo/Phone3.jpgg',
            'price' => '799.99',
            'quantity' => '13',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);
        $this->addMedia($product2, 'Phone3.jpg');


        $product3 = Product::create([
            'name' => 'Phone 3',
//            'image' => 'Demo/Phone4.jpgg',
            'price' => '799.99',
            'quantity' => '13',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);
        $this->addMedia($product3, 'Phone4.jpg');

        $product4 = Product::create([
            'name' => 'Phone 4',
//            'image' => 'Demo/Phone5.jpgg',
            'price' => '699.99',
            'quantity' => '11',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);
        $this->addMedia($product4, 'Phone5.jpg');


        $product5 = Product::create([
            'name' => 'Laptop 1',
//            'image' => 'Demo/Laptop2.jpgg',
            'price' => '999.99',
            'quantity' => '10',
            'category_id' => '2',
            'description' => 'A cool Good Thing',
        ]);
        $this->addMedia($product5, 'Laptop1.jpg');

        $product6 = Product::create([
            'name' => 'Laptop 2',
//            'image' => 'Demo/Laptop3.jpgg',
            'price' => '899.99',
            'quantity' => '11',
            'category_id' => '2',
            'description' => 'A cool Good Thing',
        ]);
        $this->addMedia($product6, 'Laptop2.jpg');

        $product7 = Product::create([
            'name' => 'Tablet 1',
//            'image' => 'Demo/Tablet2.jpgg',
            'price' => '899.99',
            'quantity' => '4',
            'category_id' => '3',
            'description' => 'Best Tablet!',
        ]);
        $this->addMedia($product7, 'Tablet1.jpg');

        $product8 = Product::create([
            'name' => 'Smart Watch 1',
//            'image' => 'Demo/Watch2.jpgg',
            'price' => '899.99',
            'quantity' => '8',
            'category_id' => '4',
            'description' => 'Cool Watch!',
        ]);
        $this->addMedia($product8, 'Watch1.jpg');

        $product9 = Product::create([
            'name' => 'Camera 1',
//            'image' => 'Demo/Camera2.jpgg',
            'price' => '899.99',
            'quantity' => '7',
            'category_id' => '5',
            'description' => 'Awesome Camera!',
        ]);
        $this->addMedia($product9, 'Camera2.jpg');
        $product10 = Product::create([
            'name' => 'Accessory 1',
//            'image' => 'Demo/Accessory2.jpgg',
            'price' => '399.99',
            'quantity' => '7',
            'category_id' => '6',
            'description' => 'Good Accessory!',
        ]);
        $this->addMedia($product10, 'Accessory1.jpg');
    }
}
