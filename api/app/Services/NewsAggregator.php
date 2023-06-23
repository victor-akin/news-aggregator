<?php

namespace App\Services;

use App\Models\Source;

class NewsAggregator
{
    public $elasticSearchService;

    public $index = "news_aggregator";

    public $aggregator_result_set = [];

    public function __construct()
    {
        $this->elasticSearchService = new ElasticSearchService;
    }

    /**
     *
     * @param Source  $source
     * @param  string   $search_term
     * @return array    $search_filter (one or more [date, category, source, author])
     */
    public function getFromApiProvider($source, $search_term, $search_filter)
    {
        $api_handler = $source->getApiHandler();

        $api_handler->init($source, $search_term, $search_filter);

        $api_handler->makeRequest();

        $api_handler->formatData();

        foreach($api_handler->result_set as $data) {

            $this->elasticSearchService->client->index([
                'index' => $this->index,
                'id' => $data['fingerprint'],
                'body' => $data
            ]);
        }

        $this->aggregator_result_set = array_merge($this->aggregator_result_set , $api_handler->result_set);

        return $api_handler->result_set;
    }

    public function search(string $search_term, array $search_filter)
    {
        return $this->elasticSearchService->search($this->index, $search_term, $search_filter);
    }
}
