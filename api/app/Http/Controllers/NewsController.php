<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\NewsAggregator;
use Illuminate\Support\Facades\Response;

class NewsController extends Controller
{
    public function getLatestNews()
    {
        $news_aggregator = new NewsAggregator;

        $res = $news_aggregator->search('', ['date' => date('Y-m-d')]);

        $ids = count($res) ? array_map(function($val){
            return $val['_source']['article_id'];
        }, $res['hits']['hits']) : [];

        if(count($ids)) return Response::json(Article::whereIn('id', $ids)->get());

        $sources = Source::all();

        $articles = $sources->map(function($source) use ($news_aggregator) {
            return $news_aggregator->getFromApiProvider($source, 'silicon', ['date' => date('Y-m-d'), 'latest' => true]);
        });

        $articles = Article::whereIn('id', collect($news_aggregator->aggregator_result_set)->pluck('article_id'))->get();

        return Response::json($articles);
    }

    public function getCategories()
    {
        return Response::json(Category::all());
    }
}
