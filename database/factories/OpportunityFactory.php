<?php

namespace Database\Factories;

use App\Models\Opportunity;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Opportunity>
 */
class OpportunityFactory extends Factory
{
    protected $model = Opportunity::class;

    public function definition(): array
    {
        return [
            'organizer_id' => 2,
            'category_id' => Category::inRandomOrder()->value('id'),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
            'status' => 'approved',
        ];
    }
}
