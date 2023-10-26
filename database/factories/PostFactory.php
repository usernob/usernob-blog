<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'thumbnail' => 'thumbnail/' . $this->faker->file('./public/template/thumbnail', './storage/app/public/thumbnail', false),
            'content' => 'content/' . $this->faker->file('./public/template/content', './storage/app/public/content', false),
            'description' => $this->faker->paragraph()
        ];
    }
}
