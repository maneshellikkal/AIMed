<div class="col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="/codes" class="card-block">
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
                <a class="nav-link{{ !request()->is('codes') || request('author') ? '' : ' active' }}"
                   href="/codes"><i class="fa fa-code"></i> All Codes</a>
            </li>

            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? ' active' : '' }}"
                       href="/codes?author={{ auth()->user()->username }}"><i class="fa fa-lightbulb-o text-info"></i> My Codes</a>
                </li>
            @endif
        </ul>
    </div>
</div>
