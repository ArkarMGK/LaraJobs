<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $regions = [
            'North America',
            'Europe',
            'Africa',
            'Australia',
            'Asia',
            'Oceania',
            'South America',
            'Other',
        ];
        $region = array_rand($regions);

        $amount = [5000, 10000, 20000, 30000, 40000, 50000];
        $index = array_rand($amount);
        $min_buget = $amount[$index];
        $max_buget = rand(2,2.5) * $min_buget;
        return [
            'name' => $this->faker->company(),
            'details' => $this->faker->sentence(30),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'location' => $this->faker->city(),
            'region' => $regions[$region],
            'min_budget' =>  $min_buget,
            'max_budget' => $max_buget,
        ];
    }
}
