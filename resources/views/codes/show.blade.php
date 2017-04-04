@extends('layouts.app')

@section('title')
    {{ $code->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            @can('edit', $code)
            <div class="col-12 align-self-end">
                <a class="pull-right btn btn-primary" href="{{ $code->path() }}/edit">Edit Code</a>
            </div>
            @endcan

            <div class="col-lg-3">
                <img class="img-fluid" src="{{ $code->dataset->getFirstMediaUrl('default', 'big') }}" alt="{{ $code->name }}">
            </div>
            <div class="col-lg-9">
                <h1 class="display-3">{{ $code->name }}</h1>
                <div class="lead">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            For dataset: <a href="{{ $code->dataset->path() }}">{{ $code->dataset->name }}</a>
                        </li>
                        <li class="list-inline-item">
                            &bull; By <a href="{{ $code->creator->path() }}">{{ $code->creator->name }}</a>
                        </li>
                        <li class="list-inline-item">
                            &bull; <small class="text-muted">Last updated {{ $code->updated_at->diffForHumans() }}</small>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Description
                    </h3>
                    <div class="card-block">
                        {!! $code->description_html !!}
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Code
                    </h3>
                    <div class="card-block">
                        <pre><code>{{ $code->code }}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._code_highlight')