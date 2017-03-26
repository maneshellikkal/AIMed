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
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DatasetFilters $filters)
    {
        $datasets = Dataset::published()
                           ->filter($filters)
                           ->with('creator')
                           ->latest()
                           ->paginate();

        return view('datasets.index', compact('datasets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('datasets.publish');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublishDatasetRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublishDatasetRequest $request)
    {
        $dataset = Dataset::create([
           'name' => $request->name,
           'overview' => $request->overview,
           'description' => $request->description,
           'user_id' => auth()->id(),
        ]);

        return redirect($dataset->path().'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param string    $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $dataset = Dataset::published()->whereSlug($slug)->firstOrFail();
        return view('datasets.show', compact('dataset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string   $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $dataset = auth()->user()->datasets()->whereSlug($slug)->firstOrFail();
        return view('datasets.edit', compact('dataset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDatasetRequest  $request
     * @param string   $slug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateDatasetRequest $request, $slug)
    {
        $dataset = auth()->user()->datasets()->whereSlug($slug)->firstOrFail();

        if($request->hasFile('image')){
            $dataset->clearMediaCollection();
            $dataset->addMedia($request->file('image'))->preservingOriginal()->toMediaCollection();
        }

        $dataset->update([
            'name' => $request->name,
            'overview' => $request->overview,
            'description' => $request->description,
            'published' => $dataset->hasMedia() && $dataset->hasMedia('files')
        ]);

        if(! $dataset->published){
            return redirect($dataset->path().'/edit')
                ->withErrors(['You need to add a display image and at least one file before publishing the dataset.']);
        }
        return redirect($dataset->path());
    }
}
