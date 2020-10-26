<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'serving_id' => 'required',
            'adults' => 'present',
            'kids' => 'present',
            'timing_id' => 'required'
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
            'serving_id.required' => 'A Serving quantity is required',
            'adults.present' => 'Please select the meal is for an adult or not',
            'kids.present' => 'Please select the meal is for an kid or not',
            'timing_id.required' => 'A time frame is required'
        ];
    }
}
