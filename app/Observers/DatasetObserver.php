<?php

namespace App\Observers;

use App\Dataset;
use Markdown;

class DatasetObserver
{
    /**
     * Listen to the Dataset creating event.
     *
     * @param  Dataset  $dataset
     * @return void
     */
    public function creating(Dataset $dataset)
    {
        $dataset->description_html = Markdown::convertToHtml($dataset->description);
    }

    /**
     * Listen to the Dataset saving event.
     *
     * @param  Dataset  $dataset
     * @return void
     */
    public function saving(Dataset $dataset)
    {
        $dataset->description_html = Markdown::convertToHtml($dataset->description);
    }
}