<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiabetesPredictionRequest;
use App\Services\PredictionRequestService;
use Illuminate\Http\Request;

class DiabetesPredictionController extends Controller
{
    public function form()
    {
        return view('predictions.diabetes');
    }

    public function predict(DiabetesPredictionRequest $request, PredictionRequestService $service)
    {
        $data = $request->only(['age', 'pregnant', 'plasma_glucose_concentration', 'diastolic_bp', 'tsft', 'serum_insulin', 'bmi', 'dpf']);
        $prediction = $service->predictDiabetes($data);
        // TODO: Persist user input to database
        return view('predictions.diabetes')->withResults($prediction);
    }
}
