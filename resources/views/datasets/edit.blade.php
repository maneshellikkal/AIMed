@extends('layouts.app')

@section('title')
    Edit Dataset
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Edit Dataset',
    ])
        <form id="edit-dataset-form" role="form" method="POST" action="{{ $dataset->path() }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-4 form-control-label text-right">Name</label>

                <div class="col-6">
                    <input id="name" type="text" class="form-control" name="name"
                           value="{{ old('name') ?: $dataset->name }}" required autofocus>

                    @if ($errors->has('name'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('overview') ? ' has-danger' : '' }}">
                <label for="overview" class="col-4 form-control-label text-right">Overview</label>

                <div class="col-6">
                    <input id="overview" type="text" class="form-control" name="overview"
                           value="{{ old('overview') ?: $dataset->overview }}" required>

                    @if ($errors->has('overview'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('overview') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label for="description" class="col-4 form-control-label text-right">Description</label>

                <div class="col-6">
                    <textarea rows="10" id="description" class="form-control" name="description"
                              required>{{ old('description') ?: $dataset->description }}</textarea>

                    @if ($errors->has('description'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </p>
                    @endif
                </div>
            </div>
            <hr/>

            <div class="form-group row{{ $errors->has('image') ? ' has-danger' : '' }}">
                <label for="image" class="col-4 form-control-label text-right">Image</label>

                <div class="col-6">
                    <input id="image" type="file" class="form-control-file" name="image">

                    @if ($errors->has('image'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('image') }}</strong>
                        </p>
                    @endif
                </div>
            </div>
        </form>

        <div class="form-group row">
            <label class="col-4 form-control-label text-right">Files</label>
            <div class="col-6 offset-4">
                <form action="{{ $dataset->path() }}/file"
                      class="dropzone">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-4">
                <a href="#" onclick="event.preventDefault();document.getElementById('edit-dataset-form').submit();"
                   class="btn btn-primary">
                    <i class="fa fa-save"> </i> Publish
                </a>
            </div>
        </div>
    @endcomponent
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
@endpush