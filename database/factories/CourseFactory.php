<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', '+1 year');
        $endDate = $this->faker->dateTimeBetween(
            $startDate->format('Y-m-d') . ' +1 month',
            $startDate->format('Y-m-d') . ' +6 months'
        );


        return [
            'name' => $this->faker->title,
            'description' => $this->faker->text(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
