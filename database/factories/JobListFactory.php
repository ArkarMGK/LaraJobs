<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobList>
 */
class JobListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $tags = ['Laravel','PHP','VueJS','Fullstack','API','TailwindCSS','JavaScript','Backend','Git','AWS',
    'TALL Stack','Frontend','Engineer','Craft CMS','Lead','Livewire','MySQL','React','Senior','SQL','AlpineJS'];
        $random_tags = array_rand($tags, 4);
        $tag = rand(0,1) ? join(',',[$tags[$random_tags[0]],$tags[$random_tags[1]],$tags[$random_tags[2]]]) :
        join(',',[$tags[$random_tags[0]],$tags[$random_tags[1]],$tags[$random_tags[2]],$tags[$random_tags[3]]]);

        $employment_type = ['full-time','contractor','intern'];
        $employment = array_rand($employment_type);

        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(5),
            'tags' => $tag,
            'job_location' => $this->faker->city(),
            'employment_type' => $employment_type[$employment],
            'salary' => (round( $this->faker->numberBetween(40000, 100000)/100))*100,
            'available' => rand('1','0'),
        ];
    }
}
