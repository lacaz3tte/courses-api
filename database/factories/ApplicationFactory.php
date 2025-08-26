<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory()->create(),
            'user_id' => User::factory()->create()
        ];
    }
}
