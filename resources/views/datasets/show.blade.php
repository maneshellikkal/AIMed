@extends('layouts.app')

@section('title')
    {{ $dataset->name }}
@endsection

@section('content')
    @if(auth()->check() && auth()->id() == $dataset->user_id)
    <div class="container">
        <div class="row mt-3">
            <div class="col align-self-end">
                <a class="pull-right btn btn-primary" href="{{ $dataset->path() }}/edit">Edit Dataset</a>
            </div>
        </div>
    </div>
    @endif

    @component('layouts.card', [
        'cardTitle' => $dataset->name,
        'cardHeadingColor' => '',
        'cardHeadingTextColor' => '',
    ])

        <hr>
        @foreach($dataset->getMedia() as $file)
            <img src="{{ $file->getUrl() }}" class="img-responsive" width="200px">
        @endforeach

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $dataset->name }}</td>
            </tr>
            <tr>
                <th>Overview</th>
                <td>{{ $dataset->overview }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $dataset->description }}</td>
            </tr>
            <tr>
                <th>Published by</th>
                <td>
                    <a href="{{ $dataset->creator->path() }}">
                        {{ $dataset->creator->name }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>Published On</th>
                <td>{{ $dataset->created_at->diffForHumans() }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ $dataset->updated_at->diffForHumans() }}</td>
            </tr>
            <tr>
                <th>Featured</th>
                <td>{{ $dataset->featured ? 'Yes' : 'No' }}</td>
            </tr>
        </table>


        <h3>Files</h3>
        @foreach($dataset->getMedia('files') as $file)
            <a href="{{ $file->getUrl() }}">{{ $file->file_name }}</a> <br>
        @endforeach
    @endcomponent
@endsection