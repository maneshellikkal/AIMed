@extends('layouts.app')

@section('title')
    Publish Dataset
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Publish Dataset',
    ])
        <form role="form" method="POST" action="/datasets">
            {{ csrf_field() }}

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

            <div class="form-group row{{ $errors->has('overview') ? ' has-danger' : '' }}">
                <label for="overview" class="col-4 form-control-label text-right">Overview</label>

                <div class="col-6">
                    <input id="overview" type="text" class="form-control" name="overview"
                           value="{{ old('overview') }}" required>

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
                    <textarea name="description" id="description" class="form-control" data-markdown>{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-arrow-right"> </i> Next
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection

@include('layouts._markdown_editor')
