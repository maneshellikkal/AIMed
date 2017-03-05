@component('layouts.card', [
    'pageTitle' => 'Datasets',
    'cardTitle' => 'Datasets',
    'cardHeadingColor' => '',
    'cardHeadingTextColor' => '',
])
    @slot('cardNavigation')
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ request()->is('datasets') && request('author') != 'me' && request('order') != 'featured' ? ' active' : '' }}"
               href="/datasets">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ request()->is('datasets') && request('author') != 'me' && request('order') == 'featured' ? ' active' : '' }}"
               href="/datasets?order=featured">Featured</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ request()->is('datasets') && request('author') == 'me' ? ' active' : '' }}"
               href="/datasets?author=me">My</a>
        </li>
    </ul>
    @endslot
    <div class="datasets-list">
        @foreach($datasets as $dataset)
            <div class="row dataset-item py-3 table-hover" data-href="/datasets/{{ $dataset->slug }}">
                <a class="dataset-item-link"></a>
                <div class="col-1">
                    <div class="vote-button-container d-flex flex-column">
                        <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                        <div class="vote-button-count px-2"><span>7</span></div>
                    </div>
                </div>
                <div class="col-2">
                    <img class="img-fluid img-responsive" src="http://placehold.it/90x90" alt="">
                </div>
                <div class="col-7">
                    <h4>{{ $dataset->name }}</h4>
                    <p class="card-text">{{ $dataset->overview }}</p>
                    <p class="card-text">
                        <small class="text-muted d-block">Author: <a
                                    href="/~{{ $dataset->author->username }}">{{ $dataset->author->name }}</a></small>
                        <small class="text-muted d-block">Last Updated: {{ $dataset->updated_at->diffForHumans() }}</small>
                    </p>
                </div>
                <div class="col-2">@mdo</div>
            </div>
        @endforeach
    </div>
@endcomponent