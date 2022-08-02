<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $arFaker = Faker::create('ar_JO');
        return [
            'title' => ['en' => $this->faker->text(20), 'ar' =>  $arFaker->text(20)],
            'image' => 'faker/categories/'. rand(1,8).'.jpg',
            'parent_id' => rand(1,8)
        ];
    }
}
