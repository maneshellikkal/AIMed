@extends('layouts.app')

@section('title')
    {{ $dataset->name }}
@endsection

@section('content')
    @if(auth()->check() && $dataset->isOwnedBy(auth()->user()))
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
        <hr>

        <h3>Files</h3>
        <div class="list-group">
            @forelse($dataset->getMedia('files') as $file)
                <a class="list-group-item" href="{{ $file->getUrl() }}">{{ $file->file_name }}</a> <br>
            @empty
                <a class="list-group-item">No Attached Files</a>
            @endforelse
        </div>
        <hr>

        <h3>Codes ({{ $dataset->codes->count() }})</h3>
        <a class="pull-right btn btn-primary" href="/c/{{ $dataset->slug }}/publish">Add Code</a>

        <div class="list-group">
            @forelse($dataset->codes as $code)
                <a class="list-group-item" href="{{ $code->path() }}">{{ $code->name }} &nbsp; <small>by {{ $code->creator->name }}</small></a> <br>
            @empty
                <a class="list-group-item">No Published Codes</a>
            @endforelse
        </div>

    @endcomponent
@endsection