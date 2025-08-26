<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test-token')->plainTextToken;
});

test('user can get courses list', function () {
    Course::factory()->count(5)->create();

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->getJson('/api/courses');

    $response->assertStatus(200)
        ->assertJsonCount(5)
        ->assertJsonStructure([[
            'id',
            'name',
            'description',
            'start_date',
            'end_date'
        ]]);
});
