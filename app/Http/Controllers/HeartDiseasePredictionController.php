<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeartDiseasePredictionRequest;
use App\Services\HeartDiseasePredictionService;

class HeartDiseasePredictionController extends Controller
{
    public function form ()
    {
        return view('predictions.heart');
    }

    public function predict (HeartDiseasePredictionRequest $request, HeartDiseasePredictionService $service)
    {
        $data = $request->only([
            'age',
            'sex',
            'cp',
            'resting_bp',
            'serum_cholesterol',
            'fasting_blood_sugar',
            'resting_ecg',
            'max_heart_rate',
            'exercise_induced_angina',
            'st_depression',
            'st_slope',
            'number_of_vessels',
            'thallium_scan_results'
        ]);

        $prediction = $service->predict($data);

        return view('predictions.heart')->withResults($prediction);
    }
}
