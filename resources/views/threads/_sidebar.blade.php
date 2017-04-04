<div class="col-md-3">
    @if(auth()->check())
    <div class="mb-3">
        <a class="btn btn-block btn-lg btn-primary" href="/discuss/create">New Discussion</a>
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="{{ request()->url() }}" class="card-block">
            @foreach(request()->except('search') as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Filter
        </div>
        <ul class="nav stacked-tabs flex-column">
            <li class="nav-item">
                <a class="nav-link{{ request()->url() == request()->fullUrl() ? ' active' : '' }}"
                   href="{{ request()->url() }}"><i class="fa fa-globe text-info"></i> All Threads</a>
            </li>
            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? ' active' : '' }}"
                       href="{{ request()->url() }}?author={{ auth()->user()->username }}{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-lightbulb-o text-info"></i> My Threads</a>
                </li>
            <li class="nav-item">
                <a class="nav-link{{ request('contributor') ? ' active' : '' }}"
                   href="{{ request()->url() }}?contributor={{ auth()->user()->username }}{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-code-fork text-info"></i> My Participation</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link{{ request('trending') ? ' active' : '' }}"
                   href="{{ request()->url() }}?trending=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fire text-danger"></i> Popular This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('popular') ? ' active' : '' }}"
                   href="{{ request()->url() }}?popular=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fire text-danger"></i> Popular All Time</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('answered') == 'true' ? ' active' : '' }}"
                   href="{{ request()->url() }}?answered=true{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-thumbs-o-up text-success"></i> Answered Threads</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('answered') == 'false' ? ' active' : '' }}"
                   href="{{ request()->url() }}?answered=false{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-frown-o text-danger"></i> Unanswered Threads</a>
            </li>
        </ul>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Categories
        </div>
        <ul class="nav stacked-tabs flex-column">
            <li class="nav-item">
                <a class="nav-link{{ request()->is('discuss') ? ' active' : '' }}"
                   href="/discuss?{{ request()->getQueryString() }}"><i class="fa fa-circle-o{{ request()->is('discuss') ? ' text-success' : ' text-muted' }}"></i> All Categories</a>
            </li>
            @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link{{ request()->is('t/'.$category->slug) ? ' active' : '' }}"
                   href="/t/{{ $category->slug }}?{{ request()->getQueryString() }}"><i class="fa fa-circle-o{{ request()->is('t/'.$category->slug) ? ' text-success' : ' text-muted' }}"></i> {{ $category->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
