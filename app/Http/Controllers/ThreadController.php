<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filters\ThreadFilters;
use App\Http\Requests\CreateThreadRequest;
use App\Thread;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category      $category
     * @param ThreadFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Category $category, ThreadFilters $filters)
    {
        $threads = $this->getThreads($category, $filters);
        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Category      $category
     * @param ThreadFilters $filters
     *
     * @return mixed
     */
    protected function getThreads (Category $category, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)->latest();
        if ($category->exists) {
            $threads->where('category_id', $category->id);
        }

        return $threads->get();
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateThreadRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (CreateThreadRequest $request)
    {
        $thread = auth()->user()->threads()->create([
            'name'        => $request->input('name'),
            'body'        => $request->input('body'),
            'category_id' => $request->input('category_id'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  string     $categorySlug
     * @param  \App\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show ($categorySlug, Thread $thread)
    {
        return view('threads.show', [
            'thread'  => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }
}
