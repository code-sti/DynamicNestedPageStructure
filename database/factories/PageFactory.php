<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Page;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => 'page' . $this->faker->unique()->numberBetween(1, 1000), // Generates page1, page2, page3, etc.
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'parent_id' => $this->faker->randomElement([null, Page::inRandomOrder()->first()?->id]), // Random parent ID or null
        ];
    }
}
