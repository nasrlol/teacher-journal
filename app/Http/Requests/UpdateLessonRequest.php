<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topic' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'group_id' => 'sometimes|required|exists:groups,id',
            'scheduled_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
        ];
    }
}
