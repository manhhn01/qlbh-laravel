<?php

namespace Database\Factories;

use App\Models\ReceivedNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceivedNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceivedNote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deliver_name' => $this->faker->lastName(),
            'receive_at' => $this->faker->dateTimeThisDecade(),
            'status'=>$this->faker->numberBetween(0, 1),
            'note'=>$this->faker->sentence()
        ];
    }
}
