<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_email'=>$this->faker->safeEmail(),
            'buy_place'=>0,
            'status'=>$this->faker->numberBetween(0, 3),
            'payment_method'=>$this->faker->numberBetween(0, 2),
            'deliver_to'=>$this->faker->address(),
            'note'=>$this->faker->sentence(5)
        ];
    }
}
