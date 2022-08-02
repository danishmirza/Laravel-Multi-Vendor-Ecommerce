<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $arFaker = Faker::create('ar_JO');
        $enTitle = $this->faker->text(20);
        return [
            'title' => ['en' => $enTitle, 'ar' =>  $arFaker->text(20)],
            'content' => ['en' => $this->faker->realText(200), 'ar' =>  $arFaker->realText(200)],
            'author' => ['en' => $this->faker->name, 'ar' =>  $arFaker->name],
            'image' => 'faker/articles/'. rand(1,8).'.jpg',
            'slug' => Str::slug($enTitle)
        ];
    }
}
