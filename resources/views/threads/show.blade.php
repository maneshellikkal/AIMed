@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <a class="text-white" href="{{ $thread->creator->path() }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->name }}
                    </div>
                    <div class="card-block">
                        {!! $thread->body_html !!}
                    </div>
                </div>

                @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}" class="mt-3">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Reply</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion.</p>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-block">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>, and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection