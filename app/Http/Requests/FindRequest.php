<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
{
    protected $errorBag = 'findErrors';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from' => 'required|integer|different:to',
            'to' => 'required|integer|different:from',
        ];
    }

    public function messages()
    {
        return [
            'from.required' => 'Поле "Откуда" обязательно.',
            'to.required' => 'Поле "Куда" обязательно.',
            'different' => 'Поля "Откуда" и "Куда" должны быть разными.',
        ];
    }
}

