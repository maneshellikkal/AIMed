<div class="card mt-2">
    <div class="card-header">
        <a href="{{ $reply->creator->path() }}">
            {{ $reply->creator->name }}
        </a>
        said {{ $reply->created_at->diffForHumans() }}...
    </div>
    <div class="card-block user-content">
        {!!  $reply->body_html !!}
    </div>
</div>