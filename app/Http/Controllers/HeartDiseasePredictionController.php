<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeartDiseasePredictionRequest;
use App\Services\PredictionRequestService;
use Illuminate\Http\Request;

class HeartDiseasePredictionController extends Controller
{
    public function form()
    {
        return view('predictions.heart');
    }

    public function predict(HeartDiseasePredictionRequest $request, PredictionRequestService $service)
    {
        $data = $request->only(['age', 'sex', 'cp', 'resting_bp', 'serum_cholesterol', 'fasting_blood_sugar', 'resting_ecg', 'max_heart_rate', 'exercise_induced_angina', 'st_depression', 'st_slope', 'number_of_vessels', 'thallium_scan_results']);
        $prediction = $service->predictHeartDisease($data);
        // TODO: Persist user input to database
        return view('predictions.heart')->withResults($prediction);
    }
}
