<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatasetFileController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth')->only('upload');
    }

    public function upload ($slug, Request $request)
    {
        $dataset = auth()->user()
                         ->datasets()
                         ->whereSlug($slug)
                         ->firstOrFail();

        if ($dataset->hasMedia('files') && count($dataset->getMedia('files')) >= config('settings.dataset.max_allowed_files')) {
            return response([
                'error' => sprintf('Maximum of %d files are allowed.', config('settings.dataset.max_allowed_files'))
            ], 403);
        }

        $media = $dataset->addMedia($request->file('file'))
                         ->preservingOriginal()
                         ->toMediaCollection('files');

        return $media->getUrl();
    }
}
