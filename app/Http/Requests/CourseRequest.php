<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'duration_hours' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published,archived'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:51200'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for the course.',
            'description.required' => 'A course curriculum description is required.',
            'thumbnail.image' => 'The thumbnail must be an image file (PNG, JPG, WebP, GIF).',
            'thumbnail.max' => 'The thumbnail image size may not exceed 5MB.',
        ];
    }
}
