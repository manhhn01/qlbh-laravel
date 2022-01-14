<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nameList = [
            'Áo khoác',
            'Áo len',
            'Áo chống nắng',
            'Áo sơ mi',
            'Áo thun',
            'Hoodie',
            'Vest'
        ];

        return [
            'name' => $this->faker->randomElement($nameList) . ' ' . $this->faker->regexify('[A-Z0-9]{5}'),
            'sku' => $this->faker->ean8(),
            'description' => $this->faker->paragraph(2),
            'quantity' => $this->faker->numberBetween(0, 300),
            'price' => $this->faker->numberBetween(1, 500) * 1000,
            'status' => $this->faker->randomElement([1, 1, 1, 1, 1, 0])
        ];
    }
}
