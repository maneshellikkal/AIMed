<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filters\TwitterFeedFilters;
use App\TwitterFeed;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TwitterFeedFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TwitterFeedFilters $filters)
    {
        $twitterFeeds = TwitterFeed::filter($filters)
                                   ->latest()
                                   ->take(20)
                                   ->get();

        $category = Category::findBySlug('news');
        $forumItems = $category instanceof Category ? $category->threads()->latest()->take(15) : [];

        return view('news.index', compact('twitterFeeds', 'forumItems'));
    }
}
