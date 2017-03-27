<?php

namespace App\Http\Controllers;

use App\Code;
use App\Dataset;
use App\Filters\CodeFilters;
use App\Http\Requests\PublishCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param CodeFilters $filters
     * @param Request     $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index (CodeFilters $filters, Request $request)
    {
        $codes = Code::filter($filters)
                     ->published()
                     ->with('creator', 'dataset')
                     ->latest()
                     ->paginate()
                     ->appends($request->all());

        return view('codes.index', compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function create ($slug)
    {
        $dataset = Dataset::published()->findBySlugOrFail($slug);

        return view('codes.publish', compact('dataset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublishCodeRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (PublishCodeRequest $request)
    {
        $code = Code::create([
            'user_id'     => auth()->id(),
            'dataset_id'  => $request->input('dataset_id'),
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'code'        => $request->input('code'),
            'published'   => $request->input('publish', false),
        ]);

        return redirect($code->path() . '/edit');
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
        $code = Code::published()->findBySlugOrFail($slug);

        return view('codes.show', compact('code'));
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
        $code = auth()->user()->codes()->with('dataset')->findBySlugOrFail($slug);

        return view('codes.edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCodeRequest $request
     * @param string            $slug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (UpdateCodeRequest $request, $slug)
    {
        $code = auth()->user()->codes()->findBySlugOrFail($slug);

        $code->update([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'code'        => $request->input('code'),
            'published'   => $request->input('publish', false),
        ]);

        return redirect($code->path());
    }
}
