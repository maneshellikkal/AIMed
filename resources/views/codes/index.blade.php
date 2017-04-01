@extends('layouts.app')

@section('title')
    Codes
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Codes</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-3">
                <div class="card mb-3">
                    <div class="card-header">
                        Search
                    </div>
                    <form method="GET" class="card-block">
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
                            <a class="nav-link{{ request('author') ? '' : ' active' }}"
                               href="/codes">All <span class="hidden-md-down">Codes</span></a>
                        </li>

                        @if(auth()->check())
                            <li class="nav-item">
                                <a class="nav-link{{ request('author') ? ' active' : '' }}"
                                   href="/codes?author={{ auth()->user()->username }}">My <span class="hidden-md-down">Codes</span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-code"> </i>  {{ $codes->total() }} {{ str_plural('Code', $codes->total()) }}
                    </div>
                    <div class="list-group list-group-flush">
                        @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
                    </div>
                    @if($codes->hasPages())
                        <div class="card-block">
                            {{ $codes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
