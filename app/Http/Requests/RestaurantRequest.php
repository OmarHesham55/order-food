<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $restaurantId = optional($this->route('restaurant'))->id;
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('restaurants','name')->ignore($restaurantId)
                ],
            'slug' => ['required','string'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'categories_id' => ['required','exists:categories,id'],
            'address' => ['required','string'],
            'phone' => [
                'required',
                'digits:11',
                'regex:/^(010|011|012|015)\d{8}$/'
            ]
        ];
    }
    protected function prepareForValidation()
    {
        if($this->has('slug'))
        {
            $this->merge([
                'slug' => Str::slug($this->slug)
            ]);
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'this field is required',
            'name.unique' => 'this restaurant already exist',
            'slug.required' => 'this field is required',
            'image.image' => 'format must be an image.',
            'image.mimes' => 'image should be jpg, png, or jpeg',
            'image.max' => 'image should be less than 2MB',
            'categories_id.required' => 'choose one category',
            'categories_id.exist' => 'Invalid category',
            'address.required' => 'this field is required',
            'phone.required' => 'phone is required',
            'phone.digits' => 'Phone must be 11 digits',
            'phone.regex' => 'wrong phone number format',
        ];
    }
}
