<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiabetesPredictionRequest extends FormRequest
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
            'age' => 'required|integer|between:1,100',
            'pregnant' => 'required|integer|min:0|max:40',
            'plasma_glucose_concentration' => 'required|integer|min:0',
            'diastolic_bp' => 'required|integer|min:0',
            'tsft' => 'required|integer|min:0',
            'serum_insulin' => 'required|integer|min:0',
            'bmi' => 'required|integer|min:0',
            'dpf' => 'required|integer|min:0',
        ];
    }
}
