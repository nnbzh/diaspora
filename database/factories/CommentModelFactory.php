<?php

namespace Database\Factories;

use App\Models\CommentModel;
use App\Models\RequestModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->limit(1)->get('id')->first(),
            'post_id' => RequestModel::inRandomOrder()->limit(1)->get('id')->first(),
            'comment' => $this->faker->text(100),
        ];
    }
}
