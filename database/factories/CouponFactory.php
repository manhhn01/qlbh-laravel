<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->ean8(),
            'discount'=>$this->faker->numberBetween(1, 99),
            'remain'=>$this->faker->numberBetween(1, 99),
            'expire_at'=>$this->faker->dateTimeThisYear('31-12-2022')
        ];
    }
}
