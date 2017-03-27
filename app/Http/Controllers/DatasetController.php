<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Filters\DatasetFilters;
use App\Http\Requests\PublishDatasetRequest;
use App\Http\Requests\UpdateDatasetRequest;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param DatasetFilters $filters
     * @param Request        $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index (DatasetFilters $filters, Request $request)
    {
        $datasets = Dataset::filter($filters)
                           ->published(true)
                           ->with('creator')
                           ->latest()
                           ->paginate()
                           ->appends($request->all());

        return view('datasets.index', compact('datasets'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('datasets.publish');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublishDatasetRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (PublishDatasetRequest $request)
    {
        $dataset = Dataset::create([
            'name'        => $request->input('name'),
            'overview'    => $request->input('overview'),
            'description' => $request->input('description'),
            'user_id'     => auth()->id(),
        ]);

        return redirect($dataset->path() . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show (string $slug)
    {
        $dataset = Dataset::published(true)
                          ->with([
                              'codes' => function ($query) {
                                  $query->published();
                              }
                          ])->findBySlugOrFail($slug);

        return view('datasets.show', compact('dataset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function edit ($slug)
    {
        $dataset = auth()->user()->datasets()->findBySlugOrFail($slug);

        return view('datasets.edit', compact('dataset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDatasetRequest $request
     * @param string               $slug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (UpdateDatasetRequest $request, $slug)
    {
        $dataset = auth()->user()->datasets()->findBySlugOrFail($slug);

        if ($request->hasFile('image')) {
            $dataset->clearMediaCollection();
            $dataset->addMedia($request->file('image'))->preservingOriginal()->toMediaCollection();
        }

        $dataset->update([
            'name'        => $request->input('name'),
            'overview'    => $request->input('overview'),
            'description' => $request->input('description'),
            'published'   => $dataset->hasMedia() && $dataset->hasMedia('files')
        ]);

        if ( ! $dataset->published) {
            return redirect($dataset->path() . '/edit')
                ->withErrors(['You need to add a display image and at least one file before publishing the dataset.']);
        }

        return redirect($dataset->path());
    }
}
