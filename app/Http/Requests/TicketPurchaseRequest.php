<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketPurchaseRequest extends FormRequest
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
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ];
        
    }
     public function messages()
    {
        return [
            'ticket_type_id.required' => 'Please select a ticket type.',
            'ticket_type_id.exists' => 'The selected ticket type is invalid.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.min' => 'You must purchase at least one ticket.',
            'name.required' => 'Please provide your full name.',
            'email.required' => 'Please provide your email address.',
            'address.required' => 'Please provide your address.',
        ];
    }
}
