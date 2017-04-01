@extends('layouts.app')

@section('title')
    News
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <ul class="nav stacked-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link{{ request('tailored') ? '' : ' active' }}"
                               href="/news">Everything</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request('tailored') ? ' active' : '' }}"
                               href="/news?tailored=true">Medicine</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-twitter"></i> Twitter Feed
                    </div>
                    <div class="list-group list-group-flush">
                        @each('news._flex_item', $twitterFeeds, 'feed', 'datasets._empty_flex_item')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
