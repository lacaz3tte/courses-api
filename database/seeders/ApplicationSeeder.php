<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $courseIds = Course::pluck('id')->toArray();
        $users = User::query()->get();

        $users->map(function (User $user) use ($faker, $courseIds){

           $user->courses()->sync($faker->randomElements($courseIds, 3));
        });
    }
}
