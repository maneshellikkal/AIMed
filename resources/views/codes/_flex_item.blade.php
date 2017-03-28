<a href="{{ $code->path() }}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-left w-100">
        <div class="d-inline-flex">
            <div class="d-inline-flex">
                <img class="img-responsive" src="{{ $code->dataset->getFirstMediaUrl() }}" style="height: 100px;">
            </div>
            <div class="d-inline-flex align-self-end h-50">
                <img class="img-responsive rounded-circle" src="{{ $code->creator->gravatar }}" style="height: 50px; margin-left: -25px;">
            </div>
        </div>
        <div class="align-self-center ml-5 w-50">
            <h5>{{ $code->name }}</h5>
            <small>By {{ $code->creator->name }}</small>
        </div>

        <div class="align-self-center w-25">
            @if(!$code->isPublished()) <div class="w-100"><span class="badge badge-warning">Not Published</span></div> @endif
            <small class="w-100">Updated {{ $code->updated_at->diffForHumans() }}</small>
        </div>
    </div>
</a>