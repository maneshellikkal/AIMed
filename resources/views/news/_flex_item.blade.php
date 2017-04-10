<div class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-start">
        {{--<div class="pr-2">--}}
        {{--<img class="img-responsive" src="https://twitter.com/{{ $feed->author_screen_name }}/profile_image?size=bigger" style="height: 100px;">--}}
        {{--</div>--}}
        <div class="px-2">
            <p class="lead">{!! makeLinksClickable($feed->body, $feed->tags)  !!}</p>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="btn btn-sm btn-outline-info" href="https://twitter.com/{{ $feed->author_screen_name }}/status/{{ $feed->twitter_id}}" target="_blank">
                        <i class="fa fa-twitter"></i> Twitter
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="btn btn-sm btn-outline-primary" href="https://twitter.com/{{ $feed->author_screen_name }}" title="{{ $feed->author_name }}" target="_blank">
                        By <img class="img-responsive rounded-circle" src="https://twitter.com/{{ $feed->author_screen_name }}/profile_image?size=mini"> {{ '@'.$feed->author_screen_name }}
                        @if($feed->author_verified)
                            <span class="fa fa-stack" style="font-size: 60%;"> <i class="fa fa-certificate fa-stack-2x"></i> <i class="fa fa-check fa-stack-1x fa-inverse"></i> </span>
                        @endif
                    </a>
                </li>
            </ul>

            @if($feed->media)
                <img class="img-fluid" src="{{ $feed->media }}">
            @endif
        </div>

        <div class="w-25 px-2">
            <small>{{ $feed->twitter_timestamp->diffForHumans() }}</small>
        </div>
    </div>
</div>
