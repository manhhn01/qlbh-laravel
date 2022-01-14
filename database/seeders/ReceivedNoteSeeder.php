<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ReceivedNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReceivedNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user2 = User::find(2);

        $products = Product::all();
        ReceivedNote::factory(10)
        ->for($user2)
        ->create()->each(function ($order) use ($products) {
            $order->products()->attach(
                $products->random(rand(3, 5))->mapWithKeys(function ($product, $key) {
                    return [
                        $product->id => [
                            'quantity' => rand(2, 15),
                            'price' =>  $product->price
                        ]
                    ];
                })->toArray(),
            );
        });
    }
}
