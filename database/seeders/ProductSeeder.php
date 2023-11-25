<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Phone 1',
            'image' => 'Demo/Phone2.jpg',
            'price' => '1199.99',
            'quantity' => '8',
            'category_id' => '1',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta debitis, architecto iure hic tempore nulla corrupti voluptate? Veniam,
             voluptatibus recusandae deleniti eum aperiam magnam,
              nam accusamus vitae ad officia culpa',
        ]);


        Product::create([
            'name' => 'Phone 2',
            'image' => 'Demo/Phone3.jpg',
            'price' => '799.99',
            'quantity' => '13',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);

        Product::create([
            'name' => 'Phone 3',
            'image' => 'Demo/Phone4.jpg',
            'price' => '799.99',
            'quantity' => '13',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);

        Product::create([
            'name' => 'Phone 4',
            'image' => 'Demo/Phone5.jpg',
            'price' => '699.99',
            'quantity' => '11',
            'category_id' => '1',
            'description' => 'A cool Good Thing',
        ]);


        Product::create([
            'name' => 'Laptop 1',
            'image' => 'Demo/Laptop2.jpg',
            'price' => '999.99',
            'quantity' => '10',
            'category_id' => '2',
            'description' => 'A cool Good Thing',
        ]);

        Product::create([
            'name' => 'Laptop 2',
            'image' => 'Demo/Laptop3.jpg',
            'price' => '899.99',
            'quantity' => '11',
            'category_id' => '2',
            'description' => 'A cool Good Thing',
        ]);

        Product::create([
            'name' => 'Tablet 1',
            'image' => 'Demo/Tablet2.jpg',
            'price' => '899.99',
            'quantity' => '4',
            'category_id' => '3',
            'description' => 'Best Tablet!',
        ]);

        Product::create([
            'name' => 'Smart Watch 1',
            'image' => 'Demo/Watch2.jpg',
            'price' => '899.99',
            'quantity' => '8',
            'category_id' => '4',
            'description' => 'Cool Watch!',
        ]);

        Product::create([
            'name' => 'Camera 2',
            'image' => 'Demo/Camera2.jpg',
            'price' => '899.99',
            'quantity' => '7',
            'category_id' => '5',
            'description' => 'Awesome Camera!',
        ]);
        Product::create([
            'name' => 'Accessory 1',
            'image' => 'Demo/Accessory2.jpg',
            'price' => '399.99',
            'quantity' => '7',
            'category_id' => '6',
            'description' => 'Good Accessory!',
        ]);
    }
}
