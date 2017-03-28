<a href="{{ $dataset->path() }}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-left w-100">
        <div class="d-inline-flex">
            <img class="img-responsive" src="{{ $dataset->getFirstMediaUrl() }}" style="height: 100px;">
        </div>
        <div class="align-self-center ml-5 w-50">
            <h5>{{ $dataset->name }}</h5>
            <small>By {{ $dataset->creator->name }}</small>
        </div>

        <div class="align-self-center w-25">
            @if(!$dataset->isPublished()) <div class="w-100"><span class="badge badge-warning">Not Published</span></div> @endif
            <small class="w-100">Updated {{ $dataset->updated_at->diffForHumans() }}</small>
        </div>
    </div>
</a>