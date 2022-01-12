<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageList=[
            '10.png', '11.jpg', '12.jpg', '13.jpeg', '14.jpg', '15.jpg', '1.jpg', '2.jpeg', '3.jpg', '4.jpg', '5.jpeg', '6.jpg', '7.jpg', '8.jpg', '9.jpg',
        ];
        return [
            'image_path' => $this->faker->randomElement($imageList),
        ];
    }
}
