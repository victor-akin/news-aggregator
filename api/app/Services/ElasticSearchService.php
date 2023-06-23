<?php

namespace App\Services;

use Exception;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchService {

    public $client;

    public function __construct()
    {
        $client = ClientBuilder::create()
            ->setHosts([config('app.elastic_search_host')])
            ->build();

        $response = $client->info();

        if(!$response->asBool() || !isset($response['version']['number'])) {
            $message = (string) $response->getBody();
            throw new Exception("Error connecting to elasticsearch host: $message");
        }

        $this->client = $client;
    }

    public function search(string $index, string $search_term, array $search_filter)
    {
        try {

            $params = $this->createParams($index, $search_term, $search_filter);

            $response = $this->client->search($params);

            return $response->asArray();

        } catch (\Throwable $th) {

            if(str_contains($th->getMessage(), 'index_not_found_exception')) return [];

            throw $th;
        }

    }

    public function createParams(string $index, string $search_term, array $search_filter)
    {
        if(isset($search_filter['date'])){

            $date = $search_filter['date'];
            unset($search_filter['date']);

            return [
                'index' => $index,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                'multi_match' => [
                                    'query' => $search_term,
                                    'fields' => $search_filter
                                ]
                            ],
                            'filter' => [
                                'range' => [
                                    'date' => [
                                        'gte' => $date
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        return [
            'index' => $index,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $search_term,
                        'fields' => $search_filter
                    ]
                ]
            ]
        ];
    }
}
