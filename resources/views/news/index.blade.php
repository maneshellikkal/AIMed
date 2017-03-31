@extends('layouts.app')

@section('title')
    News
@endsection

@section('content')
    @component('layouts.card')
        @slot('cardTitle')
            <h5><i class="fa fa-twitter"></i> Twitter Feed</h5>
        @endslot
        @slot('cardNavigation')
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ request('tailored') ? '' : ' active' }}"
                       href="/news">Everything</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request('tailored') ? ' active' : '' }}"
                       href="/news?tailored=true">Medicine</a>
                </li>
            </ul>
        @endslot
        @slot('block')
            <div class="list-group list-group-flush">
                @foreach($twitterFeeds as $feed)
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex justify-content-left w-100">
                        <div class="d-inline-flex">
                            <img class="img-responsive" src="https://twitter.com/{{ $feed->author_screen_name }}/profile_image?size=bigger" style="height: 100px;">
                        </div>
                        <div class="align-self-center ml-5 w-50">
                            <p class="lead">{{ $feed->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <small>
                                        By <a href="https://twitter.com/{{ $feed->author_screen_name }}" title="{{ $feed->author_name }}" target="_blank">
                                            {{ '@'.$feed->author_screen_name }}
                                        </a>
                                    </small>
                                </li>
                                <li class="list-inline-item">
                                    <small>
                                        <a href="https://twitter.com/{{ $feed->author_screen_name }}/status/{{ $feed->twitter_id}}" target="_blank">
                                            <i class="fa fa-external-link"></i> Twitter
                                        </a>
                                    </small>
                                </li>
                            </ul>

                            @if($feed->tags)
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <b>Tags:</b>
                                </li>
                                @foreach($feed->tags as $tag)
                                    <li class="list-inline-item">
                                        <a href="https://twitter.com/search?f=tweets&q=%23{{ $tag }}" target="_blank">#{{ $tag }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif

                            @if($feed->media)
                                <img class="img-responsive" src="{{ $feed->media }}" style="max-height: 200px;">
                            @endif
                        </div>

                        <div class="align-self-center w-25">
                            <small class="w-100">Posted {{ $feed->twitter_timestamp->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endslot
    @endcomponent
@endsection
