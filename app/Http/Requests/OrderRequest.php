<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'total_paid' => [
                'numeric',
                'min:0'
            ],
            'discount' => [
                'numeric',
                'min:0'
            ]
        ];
    }
    public function messages()
    {
        return [
            'total_paid.numeric' => 'The total paid field must be a number.',
            'total_paid.min' => 'The total paid field must be at least 0.',
            'discount.numeric' => 'The discount field must be a number.',
            'discount.min' => 'The discount field must be at least 0.'
        ];
    }
}
