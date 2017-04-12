@extends('layouts.app')

@section('title')
    News
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">News</h1>
    </div>
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <ul class="nav stacked-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link{{ request('tailored') ? '' : ' active' }}"
                               href="/news"><i class="fa fa-fw fa-globe"></i> Everything</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request('tailored') ? ' active' : '' }}"
                               href="/news?tailored=true"><i class="fa fa-fw fa-user-md"></i> Medicine</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-twitter"></i> Twitter Feed
                    </div>
                    <div class="list-group list-group-flush">
                        @each('news._flex_item', $twitterFeeds, 'feed', 'news._empty_flex_item')
                    </div>
                    @if($twitterFeeds->hasPages())
                        <div class="card-block">
                            {{ $twitterFeeds->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection