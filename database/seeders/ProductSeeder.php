<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::factory(5)->create();
        $suppliers = Supplier::factory(5)->create();
        for($i=0;$i<5;$i++){
            Product::factory(20)
                ->for($categories[$i])
                ->for($suppliers[$i])
                ->has(Image::factory(3))
                ->create();
        }
    }
}
