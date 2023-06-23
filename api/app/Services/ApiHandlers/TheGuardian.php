<?php

namespace App\Services\ApiHandlers;

use App\Services\ApiHandler;
use Illuminate\Support\Facades\Http;


class TheGuardian extends ApiHandler
{
    public $data_key = 'response.results';

    public function formatData()
    {
        $fields = [
            // keys needed  => keys in provider
            'article'       => 'blocks.body.0.bodyTextSummary',
            'title'         => 'webTitle',
            'description'   => 'webTitle',
            'category'      => 'sectionName',
            'author'        => 'The Guardian',
            'source'        => 'The Guardian',
            'date'          => 'webPublicationDate',
            'image_url'     => 'blocks.body.0.elements.3.assets.0.file',
            'article_url'   => 'webTitle'
        ];

        $this->mapFields($fields, ['source', 'author']);
    }

    public function formURL()
    {
        $url = $this->source->url;

        $url .= '/search?q=' . $this->search_string;

        if(isset($search_filter['date'])){
            $url .= '&from-date=' . $this->getDate($search_filter['date']);
        }

        $url .= '&show-blocks=body';

        $url .= '&api-key=' . config('app.the_guardian_api_key');

        return $url;
    }
}
