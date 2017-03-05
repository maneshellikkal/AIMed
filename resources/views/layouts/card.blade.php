@extends('layouts.app')

@section('title', $pageTitle ?? '')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-{{ $colSize ?? '12' }}">
                <div class="card">
                    <div class="card-header {{ $cardHeadingColor ?? 'bg-primary' }} {{ $cardHeadingTextColor ?? 'text-white' }}">{{ $cardTitle }}</div>
                    @if($cardNavigation ?? false)
                    <div class="card-header {{ $cardNavigationColor ?? '' }} {{ $cardNavigationTextColor ?? '' }}">
                        {{ $cardNavigation ?? '' }}
                    </div>
                    @endif
                    <div class="card-block">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
