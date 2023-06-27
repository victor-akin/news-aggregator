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

    public function search(string $index, string $search_term, array $search_filter, int $from = 0)
    {
        try {

            $params = $this->createParams($index, $search_term, $search_filter, $from);

            $response = $this->client->search($params);

            return $response->asArray();

        } catch (\Throwable $th) {

            if(str_contains($th->getMessage(), 'index_not_found_exception')) return [];

            throw $th;
        }

    }

    public function createParams(string $index, string $search_term, array $search_filter, int $from = 0)
    {
        $filter_string = $search_filter['category'] ?? '';
        $filter_string .= $search_filter['source'] ?? '';

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
                                    'query' => "$search_term $filter_string",
                                    'fields' => [...array_keys($search_filter), 'article', 'title', 'description']
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
                    ],
                    'from' => $from,
                    'size' => 20
                ]
            ];
        }

        return [
            'index' => $index,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' =>"$search_term $filter_string",
                        'fields' => [...array_keys($search_filter), 'article', 'title', 'description']
                    ]
                ],
                'from' => $from,
                'size' => 20
            ]
        ];
    }

    public function getLatest(string $index, int $from)
    {
        return $this->client->search([
            'index' => $index,
            'body' => [
                'query' => [
                    'match' => [
                        'date' => date('Y-m-d')
                    ]
                ],
                'from' => $from,
                'size' => 20
            ]
        ])->asArray();
    }

    public function getFeed(string $index, array $interests, int $from)
    {
        return $this->client->search([
            'index' => $index,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => implode(' ', array_values($interests)),
                        'fields' => ['article', 'title', 'description', 'author', 'source', 'category'],
                        'type' => 'cross_fields',
                    ],
                ],
                'from' => $from,
                'size' => 20
            ]
        ])->asArray();
    }
}
