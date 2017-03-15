<?php

namespace App\Http\Controllers;

use App\Services\PredictionRequestService;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function getHeart()
    {
        return view('predictions.heart');
    }

    public function postHeart(PredictionRequestService $service)
    {
        $data = request()->all();
        $prediction = $service->predictHeartDisease($data);
        // TODO: Persist user input to database
        return view('predictions.heart')->withResults($prediction);
    }

    public function getDiabetes()
    {
        return view('predictions.diabetes');
    }
    public function postDiabetes(PredictionRequestService $service)
    {
        $data = request()->all();
        $prediction = $service->predictDiabetes($data);
        // TODO: Persist user input to database
        return view('predictions.diabetes')->withResults($prediction);
    }
}
