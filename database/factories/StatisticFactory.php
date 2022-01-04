<?php

namespace Database\Factories;

use App\Models\statistic;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Statistic::class;


    private static $created_at;

    function __construct()
    {
        parent::__construct();
        self::$created_at = new Carbon('first day of December 2021');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ran_orders = [10, 20, 30, 40, 50, 60];
        $ran_products = [100, 200, 300, 400, 600];
        $ran_proceeds = [1000000, 2000000, 3000000, 4000000, 5000000];
        return [
            'order_total' => array_rand($ran_orders),
            'product_total' => array_rand($ran_products),
            'proceeds' => array_rand($ran_proceeds),
            'created_at' => self::$created_at->addDay(),
        ];
    }
}
