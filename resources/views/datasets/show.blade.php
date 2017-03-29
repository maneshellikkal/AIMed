@extends('layouts.app')

@section('title')
    {{ $dataset->name }}
@endsection

@section('content')
    @if(auth()->check() && $dataset->isOwnedBy(auth()->user()))
        <div class="container">
            <div class="row mt-3">
                <div class="col align-self-end">
                    <a class="pull-right btn btn-primary" href="{{ $dataset->path() }}/edit">Edit Dataset</a>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-3">
                <img class="img-fluid" src="{{ $dataset->getFirstMediaUrl() }}" alt="{{ $dataset->name }}" style="min-width: 200px;">
            </div>
            <div class="col-9">
                <h1 class="display-3">{{ $dataset->name }}</h1>
                <p class="lead">{{ $dataset->overview }}</p>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        By <a href="{{ $dataset->creator->path() }}">{{ $dataset->creator->name }}</a>
                    </li>
                    <li class="list-inline-item">
                        <small class="text-muted">Last updated {{ $dataset->updated_at->diffForHumans() }}</small></p>
                    </li>
                </ul>
                <p>
            </div>

            <div class="col-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Description
                    </h3>
                    <div class="card-block">
                        {!! $dataset->description_html !!}
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Files
                    </h3>
                    <div class="list-group list-group-flush">
                        @forelse($dataset->getMedia('files') as $file)
                            <a class="list-group-item" href="{{ $file->getUrl() }}">{{ $file->file_name }}</a>
                        @empty
                            <a class="list-group-item">No Attached Files</a>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3" id="dataset-codes">
                <div class="card">
                    <div class="card-header">
                        <a class="pull-right btn btn-primary" href="/c/{{ $dataset->slug }}/publish"><i class="fa fa-code"></i> Publish</a>
                        <h3>Codes ({{ $codes->total() }})</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
                    </div>
                    @if($codes->hasPages())
                    <div class="card-block">
                        {{ $codes->fragment('dataset-codes')->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection