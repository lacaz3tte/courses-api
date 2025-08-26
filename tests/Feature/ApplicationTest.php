<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Application;
use Carbon\Carbon;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test-token')->plainTextToken;

    $this->course = Course::factory()->create();
});

test('user can enroll in course', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/applications', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);

    $response->assertStatus(201)
        ->assertJson(['message' => 'Заявка успешно создана']);

    $this->assertDatabaseHas('course_user', [
        'user_id' => $this->user->id,
        'course_id' => $this->course->id
    ]);
});

test('user cannot enroll twice in same course', function () {
    Application::create([
        'user_id' => $this->user->id,
        'course_id' => $this->course->id
    ]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/applications', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
        ]);

    $response->assertStatus(422)
        ->assertJson(['message' => 'Пользователь уже записан на этот курс.']);
});

test('user can view enrollments by their email', function () {
    Application::factory()->count(2)->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->getJson("/api/applications?email=".$this->user->email);

    $response->assertStatus(200)
        ->assertJsonCount(2, 'applications');
});

test('user can view enrollments by course', function () {
    Application::factory()->count(3)->create(['course_id' => $this->course->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->getJson("/api/applications?course=".$this->course->id);

    $response->assertStatus(200)
        ->assertJsonCount(3, 'applications');
});

test('user can delete their application', function () {
    $application = Application::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->deleteJson("/api/applications/{$application->id}");

    $response->assertStatus(200)
        ->assertJson(['message' => 'Заявка успешно удалена']);

    $this->assertDatabaseMissing('course_user', ['id' => $application->id]);
});

test('user cant delete other user application', function () {
    $application = Application::factory()->create(['user_id' => User::factory()->create()->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->deleteJson("/api/applications/{$application->id}");

    $response->assertForbidden();

    $this->assertDatabaseHas('course_user', ['id' => $application->id]);
});

test('user cannot enroll in already started course', function () {
    $this->course->update(['start_date' =>  Carbon::now()->subWeek()->startOfWeek()]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/applications', [
            'course_id' => $this->course->id,
            'user_id' => $this->user->id,
        ]);

    $response->assertStatus(422)
        ->assertJson(['error' => 'Курс уже начат']);

    $this->assertDatabaseMissing('course_user', [
        'user_id' => $this->user->id,
        'course_id' => $this->course->id
    ]);
});
