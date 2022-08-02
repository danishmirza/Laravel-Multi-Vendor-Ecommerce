<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
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
            'question' => ['en' => $enTitle, 'ar' =>  $arFaker->text(20)],
            'answer' => ['en' => $this->faker->realText(200), 'ar' =>  $arFaker->realText(200)],
        ];
    }
}
