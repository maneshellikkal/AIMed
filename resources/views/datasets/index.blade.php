@extends('layouts.app')

@section('title')
    Datasets
@endsection

@section('content')
    @if(auth()->check())
    <div class="container">
        <div class="row mt-3">
            <div class="col align-self-end">
                <a class="pull-right btn btn-primary" href="/datasets/publish">Publish Dataset</a>
            </div>
        </div>
    </div>
    @endif

    @component('layouts.card', [
        'cardTitle' => 'Datasets',
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])
        @slot('cardNavigation')
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ request()->is('datasets') &&  !request('show') ? ' active' : '' }}"
                       href="/datasets">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->is('datasets') && request('show') == 'featured' ? ' active' : '' }}"
                       href="/datasets?show=featured">Featured</a>
                </li>

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('datasets') && request('show') == 'my' ? ' active' : '' }}"
                           href="/datasets?show=my">My</a>
                    </li>
                @endif
            </ul>
        @endslot

        <div class="datasets-list">
            @foreach($datasets as $dataset)
                <div class="row dataset-item py-3 table-hover">
                    <a class="dataset-item-link"></a>
                    <div class="col-1">
                        <div class="vote-button-container d-flex flex-column">
                            <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                            <div class="vote-button-count px-2"><span>7</span></div>
                        </div>
                    </div>
                    <div class="col-2">
                        <img class="img-fluid img-responsive" src="{{ $dataset->getFirstMediaUrl() }}" alt="">
                    </div>
                    <div class="col-7">
                        <h4><a href="{{ $dataset->path() }}">{{ $dataset->name }}</a></h4>
                        <p class="card-text">{{ $dataset->overview }}</p>
                        <p class="card-text">
                            <small class="text-muted d-block">Creator: <a
                                        href="{{ $dataset->creator->path() }}">{{ $dataset->creator->name }}</a></small>
                            <small class="text-muted d-block">Last Updated: {{ $dataset->updated_at->diffForHumans() }}</small>
                        </p>
                    </div>
                    <div class="col-2">@mdo</div>
                </div>
            @endforeach
        </div>

        {{ $datasets->links() }}
    @endcomponent
@endsection
