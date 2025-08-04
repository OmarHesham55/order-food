<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ];

        if ($this->isMethod('post')) {
            $rules['restaurant_id'] = 'required|exists:restaurants,id';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }
        elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }

}
