<?php

namespace App\Http\Controllers;

use App\Filters\ApplicationFilter;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function index(ApplicationFilter $applicationFilter)
    {
        $applications = Application::filter($applicationFilter)->with(['user','course'])->get();

        return response()->json(['applications' => $applications]);
    }

    public function store(ApplicationRequest $applicationRequest): JsonResponse
    {
        $course = Course::findOrFail($applicationRequest->course_id);

        if ($course->isStarted()) {
            return response()->json([
                'error' => 'Курс уже начат'
            ], 422);
        }

        $application = Application::create($applicationRequest->validated());

        return response()->json([
            'message' => 'Заявка успешно создана',
            'application' => $application->applicationInfo
        ], 201);
    }

    public function show(Application $application): JsonResponse
    {
        Gate::authorize('view', $application);
        $application->load('course', 'user');

        return response()->json([
            'application' => $application->applicationInfo
        ]);
    }

    public function destroy(Application $application): JsonResponse
    {
        Gate::authorize('delete', $application);
        $application->delete();

        return response()->json([
            'message' => 'Заявка успешно удалена'
        ], 200);
    }
}
