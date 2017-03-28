<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    /**
     * @return boolean
     */
    public function isPublished ()
    {
        return $this->attributes['published'];
    }

    /**
     * Publish the model.
     * @return $this
     */
    public function publish ()
    {
        return $this->update(['published' => true]);
    }

    /**
     * Un-publish the model.
     * @return $this
     */
    public function unPublish ()
    {
        return $this->update(['published' => false]);
    }

    /**
     * Scope for published model items.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished (Builder $query)
    {
        return $query->wherePublished(true);
    }

    /**
     * Scope for un-published model items.
     *
     * @param Builder  $query
     * @param int|null $id
     *
     * @return Builder
     */
    public function scopeWithUnpublishedFor (Builder $query, $id)
    {
        if ( ! $id) {
            return $this->builder;
        }

        return $query->orWhere(function ($query) use ($id) {
            $query->whereUserId($id);
            $query->wherePublished(false);
        });
    }
}