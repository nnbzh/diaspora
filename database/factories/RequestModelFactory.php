<?php

namespace Database\Factories;

use App\Models\CategoryModel;
use App\Models\RequestModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CityModel;
use App\Models\User;

class RequestModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence($this->faker->randomDigitNotNull),
            'user_id' => User::inRandomOrder()->limit(1)->get('id')->first()->id,
            'category_id' => CategoryModel::inRandomOrder()->limit(1)->get('id')->first()->id,
            'city_id' => CityModel::inRandomOrder()->limit(1)->get('id')->first()->id,
            'seen' => $this->faker->randomNumber(),
            'status' => 0,
            'likes' => $this->faker->randomNumber(),
        ];
    }
}
