<div class="col-md-3">
    <div class="mb-3">
        @if(auth()->check())
            <a class="btn btn-block btn-lg btn-primary" href="/datasets/publish"><i class="fa fa-database"></i> Publish Dataset</a>
        @endif
    </div>
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="/datasets" class="card-block">
            @if(request('featured'))
                <input type="hidden" name="featured" value="true">
            @endif

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
                <a class="nav-link{{ !request()->is('datasets') || request('featured') || request('author')  ? '' : ' active' }}"
                   href="/datasets">All <span class="hidden-md-down">Datasets</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('featured') ? ' active' : '' }}"
                   href="/datasets?featured=true">Featured <span class="hidden-md-down">Datasets</span></a>
            </li>

            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? ' active' : '' }}"
                       href="/datasets?author={{ auth()->user()->username }}">My <span class="hidden-md-down">Datasets</span></a>
                </li>
            @endif
        </ul>
    </div>
</div>
