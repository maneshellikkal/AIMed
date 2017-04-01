<?php

namespace App\Http\Controllers;

use App\Category;
use App\TwitterFeed;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $keywords = [
            'medicine',
            'cancer',
            'disease',
            'diagnosis',
            'medical',
            'doctor',
            'hospital',
            'treatment',
            'diabetes',
            'breast',
            'lung',
            'brain',
            'tumor',
            'health',
            'health care',
            'clinic',
            'prescription',
            'drugs',
            'pacemaker',
            'digitalhealth',
        ];

        $twitterFeeds = (request('tailored') ?
                            TwitterFeed::search(implode(' ', $keywords)) :
                            new TwitterFeed()
                        )->orderBy('created_at', 'desc')
                         ->take(20)
                         ->get();

        $category   = Category::findBySlug('news');
        $forumItems = $category instanceof Category ? $category->threads()->latest()->take(15) : [];

        return view('news.index', compact('twitterFeeds', 'forumItems'));
    }
}
