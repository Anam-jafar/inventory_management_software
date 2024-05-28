<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:0'
            ],
        ];
    }
    public function messages()
    {
        return [
            'amount.required' =>'The amount field is required',
            'amount.numeric' => 'The amount field must be a number.',
            'amount.min' => 'The amount field must be at least 0.',
        ];
    }
}
