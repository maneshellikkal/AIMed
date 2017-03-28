@extends('layouts.app')

@section('title')
    {{ $code->name }} - {{ $code->dataset->name }}
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Edit Code - '.$code->name
    ])
        <form role="form" method="POST" action="{{ $code->path() }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-4 form-control-label text-right">Name</label>

                <div class="col-6">
                    <input id="name" type="text" class="form-control" name="name"
                           value="{{ old('name') ?: $code->name }}" required autofocus>

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
                    <textarea rows="10" id="description" class="form-control" name="description"
                              required>{{ old('description') ?: $code->description }}</textarea>

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
                    <textarea name="code" id="code" hidden>{{ old('code') ?: $code->code }}</textarea>
                    <div id="code-editor" class="form-control"></div>

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
                            <input class="form-check-input" type="checkbox" value="1" name="publish" {{ (old('publish') ?: $code->published) ? 'checked' : '' }}> Publish Code
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