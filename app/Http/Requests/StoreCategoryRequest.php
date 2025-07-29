<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required','string'],
            'slug' => ['required','string']
        ];
         if($this->has('id'))
         {
             $rules['slug'][] = Rule::unique('categories','slug')->ignore($this->id);
         }else
         {
             $rules['slug'][] = 'unique:categories,slug';
         }
         return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->slug)
        ]);
    }

    public function messages()
    {
        return [
            'name.required' => 'this field is required',
            'slug.required' => 'this field is required',
            'slug.unique' => 'this field already exist'
        ];
    }
}
