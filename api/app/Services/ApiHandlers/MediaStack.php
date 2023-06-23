<?php

namespace App\Services\ApiHandlers;

use App\Services\ApiHandler;

class MediaStack extends ApiHandler
{
    public $data_key = 'data';

    public function formatData()
    {
        $fields = [
            // keys needed  => keys in provider
            'article'       => 'description',
            'title'         => 'title',
            'description'   => 'description',
            'category'      => 'category',
            'author'        => 'author',
            'source'        => 'source',
            'date'          => 'published_at',
            'image_url'     => 'image',
            'article_url'   => 'url'
        ];

        $this->mapFields($fields);
    }

    public function formURL()
    {
        $url = $this->source->url;

        $url .= '/v1/news?keywords=' . $this->search_string . '&countries=us,gb,de';

        if(isset($this->search_filter['date'])){
            $url .= '&date=' . $this->getDate($this->search_filter['date']);
        }

        $url .= '&limit=100&access_key=' . config('app.mediastack_key');

        return $url;
    }
}
