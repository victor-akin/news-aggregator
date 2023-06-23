<?php

namespace App\Services\ApiHandlers;

use App\Services\ApiHandler;

class NewsApi extends ApiHandler
{
    public $data_key = 'articles';

    public function formatData()
    {
        $fields = [
            // keys needed  => keys in provider
            'article'       => 'content',
            'title'         => 'title',
            'description'   => 'description',
            'category'      => 'description',
            'author'        => 'author',
            'source'        => 'source.name',
            'date'          => 'publishedAt',
            'image_url'     => 'urlToImage',
            'article_url'   => 'url'
        ];

        $this->mapFields($fields);
    }

    public function formURL()
    {
        if(empty($this->search_string)) { // latest

            return $this->source->url . '/v2/top-headlines?country=us&apiKey=' . config('app.newsapi_key');
        }

        if(isset($this->search_filter['date'])){

            $date = $this->getDate($this->search_filter['date']);

            $range = '&from=' . $date . '&to=' . $date;

            $with_search_string = '/v2/everything?q=' . $this->search_string . $range . '&apiKey=';

            return $this->source->url . $with_search_string . config('app.newsapi_key');
        }

        $with_search_string = '/v2/everything?q=' . $this->search_string . '&apiKey=';

        return $this->source->url . $with_search_string . config('app.newsapi_key');
    }
}
