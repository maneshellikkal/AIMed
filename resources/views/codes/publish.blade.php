@extends('layouts.app')

@section('title')
    Publish Code - {{ $dataset->name }}
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Publish Code for '. $dataset->name,
    ])
        <form role="form" method="POST" action="/codes">
            {{ csrf_field() }}

            <input type="hidden" name="dataset_id" value="{{ $dataset->id }}">

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-4 form-control-label text-right">Name</label>

                <div class="col-6">
                    <input id="name" type="text" class="form-control" name="name"
                           value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label for="description" class="col-4 form-control-label text-right">Description</label>

                <div class="col-6">
                    <textarea name="description" id="description" class="form-control" data-markdown>{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('code') ? ' has-danger' : '' }}">
                <label for="code" class="col-4 form-control-label text-right">Code</label>

                <div class="col-6">
                    <textarea name="code" id="code" class="form-control" data-editor="python" rows="20">{{ old('code') }}</textarea>

                    @if ($errors->has('code'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('code') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('publish') ? ' has-danger' : '' }}">
                <div class="col-6 offset-4">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="publish" {{ old('publish') ? 'checked' : '' }}> Publish Code
                        </label>
                    </div>

                    @if ($errors->has('publish'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('publish') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"> </i> Save
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection

@include('layouts._code_editor')
@include('layouts._markdown_editor')
