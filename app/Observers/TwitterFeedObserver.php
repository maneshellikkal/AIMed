<?php

namespace App\Observers;

use App\TwitterFeed;

class TwitterFeedObserver
{
    protected $keywords = [
        'medicine',
        'cancer',
        'disease',
        'diagnosis',
        'medical',
        'doctor',
        'hospital',
        'treatment',
        'diabetes',
        'breast',
        'lung',
        'brain',
        'tumor',
        'health',
        'health care',
        'clinic',
        'prescription',
        'drugs',
        'pacemaker',
        'digitalhealth',
        'cognitive',
    ];

    /**
     * Listen to the TwitterFeed created event.
     *
     * @param  TwitterFeed $feed
     *
     * @return void
     */
    public function created (TwitterFeed $feed)
    {
        if (TwitterFeed::search(implode(' ', $this->keywords))->where('id', $feed->id)->first()) {
            $feed->update(['medicine_related' => true]);
        }
    }
}