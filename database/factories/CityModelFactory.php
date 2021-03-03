<?php

namespace Database\Factories;

use App\Models\CityModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CountryModel;

class CityModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CityModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => CountryModel::inRandomOrder()->limit(1)->get('id')->first(),
            'city_name' => $this->faker->unique()->city
        ];
    }
}
