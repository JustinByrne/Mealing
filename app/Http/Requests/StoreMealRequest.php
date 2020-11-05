<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class StoreMealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('meal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
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
            'adults' => 'required',
            'kids' => 'required',
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
            'adults.required' => 'Please select the meal is for an adult or not',
            'kids.required' => 'Please select the meal is for an kid or not',
            'timing_id.required' => 'A time frame is required'
        ];
    }
}
