<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('course_user')->where(function ($query) {
                    return $query->where('user_id', $this->user_id);
                }),
            ],
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.unique' => 'Пользователь уже записан на этот курс.',
        ];
    }
}
