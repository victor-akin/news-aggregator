<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Source;
use App\Models\Article;
use Illuminate\Support\Facades\Http;

abstract class ApiHandler
{
    public $source;

    public $search_string;

    public $search_filter;

    public $formatted_data = [];

    public $fingerprint;

    public $articles_from_source = [];

    public $new_article;

    public $result_set = [];


    public function init(Source $source, string $search_string, array $search_filter)
    {
        $this->source = $source;
        $this->search_string = $search_string;
        $this->search_filter = $search_filter;
    }

    abstract public function formatData();

    abstract public function formURL();

    function createFingerprint()
    {
        return $this->fingerprint = hash('ripemd160', json_encode($this->formatted_data));
    }

    function getDate($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    function mapFields($fields, $exempt = [])
    {
        foreach($this->articles_from_source as $article) {

            $this->formatted_data = [
                'article'       => $this->getMapping('article', $fields, $exempt, $article),
                'title'         => $this->getMapping('title', $fields, $exempt, $article),
                'description'   => $this->getMapping('description', $fields, $exempt, $article),
                'category'      => $this->getMapping('category', $fields, $exempt, $article),
                'author'        => $this->getMapping('author', $fields, $exempt, $article),
                'source'        => $this->getMapping('source', $fields, $exempt, $article),
                'date'          => $this->getDate($this->getMapping('date', $fields, $exempt, $article)),
                'image_url'     => $this->getMapping('image_url', $fields, $exempt, $article),
                'article_url'   => $this->getMapping('article_url', $fields, $exempt, $article)
            ];

            $this->createFingerprint();

            $this->new_article = Article::where('fingerprint', $this->fingerprint)->first();

            if(is_null($this->new_article)){

                $this->new_article = Article::create([
                    'source_id' => $this->source->getkey(),
                    'source_article' => $article,
                    'fingerprint' => $this->fingerprint,
                    'formatted_article' => $this->formatted_data
                ]);
            }

            $this->formatted_data['article_id'] = $this->new_article->id;
            $this->formatted_data['fingerprint'] = $this->fingerprint;

            $this->result_set[] = $this->formatted_data;
        }
    }

    public function getMapping(string $field, array $fields, array $exempt, array $article)
    {
        return in_array($field, $exempt) ? data_get($fields, $field) : data_get($article, $fields[$field]);
    }

    public function makeRequest()
    {
        $url = $this->formURL();

        $response = Http::withHeaders($this->setHeaders())->get($url);

        if($response->ok()) $this->articles_from_source = data_get($response->json(), $this->data_key);
    }

    public function setHeaders()
    {
        return [];
    }
}
