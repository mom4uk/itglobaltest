<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
{
    protected $errorBag = 'findErrors';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => 'required|integer|different:to',
            'to' => 'required|integer|different:from',
        ];
    }

    public function messages(): array
    {
        return [
            'from.required' => 'Поле "Откуда" обязательно.',
            'to.required' => 'Поле "Куда" обязательно.',
            'different' => 'Поля "Откуда" и "Куда" должны быть разными.',
        ];
    }
}
