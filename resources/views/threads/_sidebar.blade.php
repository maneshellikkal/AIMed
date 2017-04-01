<div class="col-md-3">
    <div class="mb-3">
        @if(auth()->check())
            <a class="btn btn-block btn-lg btn-primary" href="/discuss/create">New Discussion</a>
        @endif
    </div>
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="/discuss" class="card-block">
            @if($author = request('author'))
                <input type="hidden" name="author" value="{{ $author }}">
            @endif
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                            </span>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            Filter
        </div>
        <ul class="nav stacked-tabs flex-column">
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss"><i class="fa fa-globe text-info"></i> All Threads</a>
            </li>
            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link"
                       href="/discuss?author={{ auth()->user()->username }}"><i class="fa fa-lightbulb-o text-info"></i> My Threads</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss?filter_by=contributed_to"><i class="fa fa-code-fork text-info"></i> My Participation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss?trending=1"><i class="fa fa-fire text-danger"></i> Popular This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss?popular=1"><i class="fa fa-fire text-danger"></i> Popular All Time</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss?answered=1"><i class="fa fa-thumbs-o-up text-success"></i> Answered Threads</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="/discuss?answered=0"><i class="fa fa-frown-o text-danger"></i> Unanswered Threads</a>
            </li>
        </ul>
    </div>
</div>
