<?php

namespace Database\Factories;

use App\Models\Novel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NovelFactory extends Factory
{
    protected $model = Novel::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'synopsis' => $this->faker->paragraphs(3, true),
            'cover' => null,
            'genre' => $this->faker->randomElement(['Fantasy', 'Romance', 'Mystery', 'Action', 'Drama']),
            'status' => $this->faker->randomElement(['ongoing', 'completed']),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
