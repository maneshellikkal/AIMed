<div class="card py-2">
    <div class="card-block">
        <div class="media">
            <div class="d-flex flex-column align-items-center mr-3">
                <img class="mb-1" src="{{ $reply->creator->gravatar }}" alt="{{ $reply->creator->name }}">
                @if(!($embeded ?? false))
                @can('select-best-answer', $reply->thread)
                    @if($reply->thread->isNotAnswered())
                        <div>
                            <form method="POST" action="{{ $reply->path() }}">
                                {!! csrf_field() !!}
                                {!! method_field('PUT') !!}

                                <button type="submit" class="btn bg-faded text-white" title="Did this answer your question?">
                                    <i class="fa fa-fw fa-thumbs-up"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endcan
                @can('update', $reply)
                    <a href="{{ $reply->path() }}/edit" class="btn bg-warning text-white">
                        <i class="fa fa-fw fa-edit"></i>
                    </a>
                @endcan
                @endif
            </div>
            <div class="media-body">
                <h5 class="mt-0">
                    {{ $reply->creator->name }}
                    <small class="text-muted">
                        {{ $reply->created_at->diffForHumans() }}
                    </small>

                    @if(!($embeded ?? false))
                    @if($reply->isBestAnswer())
                        <span class="badge badge-success">Best Answer</span>
                    @endif
                    @endif
                </h5>
                <div class="user-content">
                    {!! $reply->body_html !!}
                </div>
            </div>
        </div>
    </div>
</div>