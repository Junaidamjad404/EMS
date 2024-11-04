<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Update this if you have authorization logic
    }

    public function rules()
    {
            // Retrieve the ticket type ID from the route parameter
        $ticketTypeId = $this->route('ticket_type')->id;

        return [
            'name' => 'required|string|max:255|unique:ticket_types,name,' . $ticketTypeId,
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'benefits' => 'nullable|string',
            'quantity' => 'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The ticket type name is required.',
            'name.unique' => 'The ticket type name must be unique.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
            'benefits.string' => 'The benefits must be a string.',
        ];
    }
}
