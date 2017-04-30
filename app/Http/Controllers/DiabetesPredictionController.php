<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiabetesPredictionRequest;
use App\Services\DiabetesPredictionService;

class DiabetesPredictionController extends Controller
{
    public function form ()
    {
        return view('predictions.diabetes');
    }

    public function predict (DiabetesPredictionRequest $request, DiabetesPredictionService $service)
    {
        $data = $request->only([
            'age',
            'pregnant',
            'plasma_glucose_concentration',
            'diastolic_bp',
            'tsft',
            'serum_insulin',
            'bmi',
            'dpf'
        ]);

        $prediction = $service->predict($data);

        return view('predictions.diabetes')->withResults($prediction);
    }
}
