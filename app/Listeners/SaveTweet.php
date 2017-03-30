<?php

namespace App\Listeners;

use App\Events\TweetRetrieved;
use App\TwitterFeed;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveTweet
{
    /**
     * Handle the event.
     *
     * @param  TweetRetrieved $event
     *
     * @return void
     */
    public function handle (TweetRetrieved $event)
    {
        TwitterFeed::create([
            'twitter_id' => $event->tweet['id_str'],
            'body' => $event->tweet['text'],
            'full_body' => $event->tweet['extended_tweet']['full_text'] ?? $event->tweet['text'],
            'user_id' => $event->tweet['user']['id_str'],
            'author_name' => $event->tweet['user']['name'],
            'author_screen_name' => $event->tweet['user']['screen_name'],
            'twitter_timestamp' => Carbon::createFromTimestamp($event->tweet['timestamp_ms']/1000),
            'media' => $event->tweet['extended_tweet']['entities']['media'][0]['media_url'] ?? null,
            'tags' => array_pluck($event->tweet['entities']['hashtags'] ?? [], 'text'),
        ]);
    }
}
