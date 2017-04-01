<?php

namespace App\Filters;

use DB;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class DatasetFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['featured', 'author', 'search'];

    /**
     * Show only featured datasets.
     *
     * @param $value
     *
     * @return Builder
     */
    public function featured($value)
    {
        return $this->builder->featured();
    }

    /**
     * Filter datasets by user.
     *
     * @param $username
     *
     * @return Builder
     */
    public function author($username)
    {
        $id = User::findByUsername($username, ['id'])->id ?? null;
        return $id ? $this->builder->whereUserId($id) : $this->builder;
    }

    /**
     * Filter dataset by search query.
     *
     * @param $query
     *
     * @return Builder
     */
    public function search($query)
    {
        $keywords = array_filter(explode(' ', $query));

        return $this->builder->where(function($query) use($keywords) {
            foreach($keywords as $word){
                $query->orWhere(DB::raw('lower(name)'), 'like', '%'.strtolower($word).'%');
            }
        });
    }
}