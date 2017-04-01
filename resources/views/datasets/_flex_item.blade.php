<a href="{{ $dataset->path() }}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-left w-100">
        <div class="d-inline-flex align-self-center w-25">
            <div>
                <img class="img-fluid" src="{{ $dataset->getFirstMediaUrl('default', 'thumb') }}">
            </div>
        </div>
        <div class="align-self-center pl-5 w-50">
            <h5>{{ $dataset->name }}</h5>
            <p class="lead">{{ $dataset->overview }}</p>
            <small>By {{ $dataset->creator->name }}</small>
        </div>

        <div class="align-self-center w-25">
            @if($dataset->isNotPublished()) <div class="w-100"><span class="badge badge-warning">Not Published</span></div> @endif
            <small class="w-100">Updated {{ $dataset->updated_at->diffForHumans() }}</small>
        </div>
    </div>
</a>