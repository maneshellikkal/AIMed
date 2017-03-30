@extends('layouts.app')

@section('title')
    Datasets
@endsection

@section('content')
    @if(auth()->check())
    <div class="container">
        <div class="row mt-3">
            <div class="col align-self-end">
            </div>
        </div>
    </div>
    @endif

    @component('layouts.card', [
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])
        @slot('cardTitle')
            <a class="pull-right btn btn-primary" href="/datasets/publish"><i class="fa fa-database"></i> Publish</a>
            <h3><i class="fa fa-database"></i> Datasets</h3>
        @endslot
        @slot('cardNavigation')
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ request('featured') || request('user')  ? '' : ' active' }}"
                       href="/datasets">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request('featured') ? ' active' : '' }}"
                       href="/datasets?featured=true">Featured</a>
                </li>

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link{{ request('user') ? ' active' : '' }}"
                           href="/datasets?user={{ auth()->user()->username }}">My</a>
                    </li>
                @endif
            </ul>
        @endslot

        @slot('block')
            <div class="list-group list-group-flush">
                @each('datasets._flex_item', $datasets, 'dataset', 'datasets._empty_flex_item')
            </div>
            @if($datasets->hasPages())
                <div class="card-block">
                    {{ $datasets->links() }}
                </div>
            @endif
        @endslot
    @endcomponent
@endsection
