@extends('layouts.app')

@section('title')
    {{ $code->name }}
@endsection

@section('content')
    @if(auth()->check() && $code->isOwnedBy(auth()->user()))
        <div class="container">
            <div class="row mt-3">
                <div class="col align-self-end">
                    <a class="pull-right btn btn-primary" href="{{ $code->path() }}/edit">Edit Code</a>
                </div>
            </div>
        </div>
    @endif

    @component('layouts.card', [
        'cardTitle' => $code->name,
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $code->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $code->description }}</td>
            </tr>
            <tr>
                <th>Code</th>
                <td>{{ $code->code }}</td>
            </tr>
            <tr>
                <th>Published by</th>
                <td>
                    <a href="{{ $code->creator->path() }}">
                        {{ $code->creator->name }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>Published</th>
                <td>{{ $code->published ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $code->created_at->diffForHumans() }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ $code->updated_at->diffForHumans() }}</td>
            </tr>
        </table>
    @endcomponent
@endsection