<?php

namespace App\Filters;

class TwitterFeedFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     * @var array
     */
    protected $filters = [];

    public function tailored ($value)
    {
        $keywords = [
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
        ];

        return $this->builder->where(function ($query) use ($keywords) {
            foreach ($keywords as $word) {
                $query->orWhere(\DB::raw('  lower(full_body)'), 'like', "%{$word}%");
            }
        });
    }
}