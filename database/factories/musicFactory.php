<?php

namespace Database\Factories;

use App\Models\music;
use Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class musicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = music::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'brand' => $this->faker->name,
            'src' => 'https://www.example.com',
            'release_date' => $this->faker->date
        ];
    }
}
