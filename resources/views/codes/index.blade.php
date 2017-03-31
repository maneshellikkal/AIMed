@extends('layouts.app')

@section('title')
    Codes
@endsection

@section('content')
    @component('layouts.card', [
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])
        @slot('cardTitle')
            <h3><i class="fa fa-code"></i> Codes</h3>
        @endslot
        @slot('cardNavigation')
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? '' : ' active' }}"
                       href="/codes">All</a>
                </li>

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link{{ request('author') ? ' active' : '' }}"
                           href="/codes?author={{ auth()->user()->username }}">My</a>
                    </li>
                @endif
            </ul>
        @endslot
        @slot('block')
            <div class="list-group list-group-flush">
                @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
            </div>
            @if($codes->hasPages())
                <div class="card-block">
                    {{ $codes->links() }}
                </div>
            @endif
        @endslot
    @endcomponent
@endsection
