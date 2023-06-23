<?php

namespace App\Services\ApiHandlers;

use App\Services\ApiHandler;

class NewsCatcher extends ApiHandler
{
    public $data_key = 'articles';

    public function formatData()
    {
        $fields = [
            // keys needed  => keys in provider
            'article'       => 'summary',
            'title'         => 'title',
            'description'   => 'excerpt',
            'category'      => 'topic',
            'author'        => 'author',
            'source'        => 'source',
            'date'          => 'published_date',
            'image_url'     => 'media',
            'article_url'   => 'link'
        ];

        $this->mapFields($fields);
    }

    public function formURL()
    {
        $url = $this->source->url;

        if(isset($this->search_filter['latest'])){

            $url .= '/v2/latest_headlines?';

            return $url;
        }

        $url .= '/v2/search?q=' . $this->search_term;

        if(isset($this->search_filter['date'])){
            $url .= '&from=' . $this->getDate($this->search_filter['date']);
        }

        $url .= '&page_size=100';

        return $url;
    }

    public function setHeaders()
    {
        return ['x-api-key' => config('app.newswatcher_key')];
    }
}
