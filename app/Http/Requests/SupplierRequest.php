<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'regex:/^[A-Za-z\s]+$/'
            ],
            'contact' => [
                'required',
                'regex:/^(\+?[0-9]{13}|[0-9]{11})$/'
            ],
            'to_be_paid' => [
                'numeric',
                'min:0'
            ],
            'total_given' => [
                'numeric',
                'min:0'
            ]
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters and spaces.',
            'contact.required' => 'The contact field is required.',
            'contact.regex' => 'The contact must be a valid phone number (either + followed by 13 digits or 11 digits without +).',
            'to_be_paid.numeric' => 'The to be paid field must be a number.',
            'to_be_paid.min' => 'The to be paid field must be at least 0.',
            'total_given.numeric' => 'The total given field must be a number.',
            'total_given.min' => 'The total given field must be at least 0.'
        ];
    }
}
