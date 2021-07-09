<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('meal_edit'), 403);
        
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
            'category_id' => 'exists:App\Models\Category,id',
            'instruction' => 'required'
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
            'timing.required' => 'A time frame is required',
            'instruction.required' => 'Instructions are required',
        ];
    }
}
