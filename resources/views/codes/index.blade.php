@extends('layouts.app')

@section('title')
    Codes
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Codes',
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])
        @slot('cardNavigation')
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ !request('show') ? ' active' : '' }}"
                       href="/codes">All</a>
                </li>

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link{{ request('show') == 'my' ? ' active' : '' }}"
                           href="/codes?show=my">My</a>
                    </li>
                @endif
            </ul>
        @endslot

        <div class="codes-list">
            @foreach($codes as $code)
                <div class="row code-item py-3 table-hover">
                    <a class="code-item-link"></a>
                    <div class="col-1">
                        <div class="vote-button-container d-flex flex-column">
                            <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                            <div class="vote-button-count px-2"><span>7</span></div>
                        </div>
                    </div>
                    <div class="col-2">
                        <img class="img-fluid img-responsive" src="{{ $code->dataset->getFirstMediaUrl() }}" alt="">
                    </div>
                    <div class="col-7">
                        <h4><a href="{{ $code->path() }}">{{ $code->name }}</a></h4>
                        <p class="card-text">For Dataset: <a href="{{ $code->dataset->path() }}">{{ $code->dataset->name }}</a></p>
                        <p class="card-text">
                            <small class="text-muted d-block">Creator: <a
                                        href="{{ $code->creator->path() }}">{{ $code->creator->name }}</a></small>
                            <small class="text-muted d-block">Last Updated: {{ $code->updated_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $codes->links() }}
    @endcomponent
@endsection
