<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create(['name' => 'NVIDIA GeForce RTX 3070']);
        Product::create(['name' => 'NVIDIA GeForce RTX 3090']);
        Product::create(['name' => 'Intel I5 4460x']);
        Product::create(['name' => 'AMD Ryzen 5']);
        Product::create(['name' => 'NVIDIA GeForce 315']);
    }
}
