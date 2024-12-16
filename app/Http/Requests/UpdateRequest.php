<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $errorBag = 'updateErrors';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'route_id' => 'required|integer|exists:routes,id',
            'stop_ids' => 'required|string|regex:/^(\d+,)*\d+$/',
            'is_direction_forward' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'route_id.required' => 'Поле "ID маршрута" обязательно.',
            'route_id.integer' => 'Поле "ID маршрута" должно быть числом.',
            'route_id.exists' => 'Указанный маршрут не существует.',
            'stop_ids.required' => 'Поле "ID остановок" обязательно.',
            'stop_ids.regex' => 'Поле "ID остановок" должно быть строкой вида "1,2,3".',
            'is_direction_forward.required' => 'Поле "Направление" обязательно.',
            'is_direction_forward.boolean' => 'Поле "Направление" должно быть true или false.',
        ];
    }
}

