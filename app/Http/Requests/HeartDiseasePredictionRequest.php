<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeartDiseasePredictionRequest extends FormRequest
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
            'age' => 'required|integer|between:1,200',
            'sex' => 'required|integer|in:0,1',
            'cp' => 'required|integer|in:1,2,3,4',
            'resting_bp' => 'required|integer|min:1',
            'serum_cholesterol' => 'required|integer|min:1',
            'fasting_blood_sugar' => 'required|integer|min:1',
            'resting_ecg' => 'required|integer|in:0,1,2',
            'max_heart_rate' => 'required|integer|min:1',
            'exercise_induced_angina' => 'required|integer|in:0,1',
            'st_depression' => 'required|integer|min:0',
            'st_slope' => 'required|integer|in:1,2,3',
            'number_of_vessels' => 'required|integer|in:0,1,2,3',
            'thallium_scan_results' => 'required|integer|in:3,6,7',
        ];
    }
}
