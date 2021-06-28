<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('meal_create'), 403);
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'servings' => 'required',
            'adults' => 'nullable',
            'kids' => 'nullable',
            'timing' => 'required',
            'instruction' => 'required',
            'ingredients' => 'required|array',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'servings.required' => 'A Serving quantity is required',
            'adults.required' => 'Please select the recipe is for an adult or not',
            'kids.required' => 'Please select the recipe is for an kid or not',
            'timing.required' => 'A time frame is required',
            'ingredient.required' => 'An ingredient is required',
            'ingredient.array' => 'An ingredient is required',
        ];
    }
}
