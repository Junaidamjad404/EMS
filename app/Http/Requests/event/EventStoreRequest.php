<?php

namespace App\Http\Requests\event;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole('event_organizer')|| Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'organizer_id' => 'required|exists:users,id',
            'promotional_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif', // max size 2MB
            'promotional_videos.*' => 'nullable|mimes:mp4,avi,mov,wmv',
        ];
    }
}
