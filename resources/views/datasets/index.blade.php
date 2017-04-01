@extends('layouts.app')

@section('title')
    Datasets
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Datasets</h1>
        @if(auth()->check())
        <a class="btn btn-primary" href="/datasets/publish"><i class="fa fa-database"></i> Publish Dataset</a>
        @endif
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-3">
                <div class="card mb-3">
                    <div class="card-header">
                        Search
                    </div>
                    <form method="GET" action="{{ request()->fullUrl() }}" class="card-block">
                        @if(request('featured'))
                            <input type="hidden" name="featured" value="true">
                        @endif

                        @if($author = request('author'))
                            <input type="hidden" name="author" value="{{ $author }}">
                        @endif
                        <div class="input-group">
                            <input name="search" type="text" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <ul class="nav stacked-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link{{ request('featured') || request('author')  ? '' : ' active' }}"
                               href="/datasets">All <span class="hidden-md-down">Datasets</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request('featured') ? ' active' : '' }}"
                               href="/datasets?featured=true">Featured <span class="hidden-md-down">Datasets</span></a>
                        </li>

                        @if(auth()->check())
                            <li class="nav-item">
                                <a class="nav-link{{ request('author') ? ' active' : '' }}"
                                   href="/datasets?author={{ auth()->user()->username }}">My <span class="hidden-md-down">Datasets</span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-database"> </i>  {{ $datasets->total() }} {{ str_plural('Dataset', $datasets->total()) }}
                    </div>
                    <div class="list-group list-group-flush">
                        @each('datasets._flex_item', $datasets, 'dataset', 'datasets._empty_flex_item')
                    </div>
                    @if($datasets->hasPages())
                        <div class="card-block">
                            {{ $datasets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
