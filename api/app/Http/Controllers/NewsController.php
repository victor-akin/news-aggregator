<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\Article;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Services\NewsAggregator;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class NewsController extends Controller
{
    public function getLatestNews(Request $request, NewsAggregator $news_aggregator): JsonResponse
    {
        $res = $news_aggregator->getLatest((int) $request->query('from'));

        $ids = array_map(function($val){
            return $val['_source']['article_id'];
        }, $res['hits']['hits']);

        if(count($ids)) return Response::json(Article::whereIn('id', $ids)->get());

        $sources = Source::all();

        $articles = $sources->map(function($source) use ($news_aggregator) {
            return $news_aggregator->getFromApiProvider($source, '', ['date' => date('Y-m-d')]);
        });

        $articles = Article::whereIn('id', collect($news_aggregator->aggregator_result_set)->pluck('article_id'))->get();

        return Response::json($articles);
    }

    public function getCategories(Request $request): JsonResponse
    {
        return Response::json([
            'news_category' => NewsCategory::all(),
            'news_authors' => NewsAuthor::all(),
            'news_sources' => NewsSource::all(),
        ]);
    }

    public function search(Request $request, NewsAggregator $news_aggregator): JsonResponse
    {
        $filter_keys = ['category', 'source', 'date', 'search_term'];

        $request->validate([
            'search_term' => ['required']
        ]);

        $filter = [];

        foreach($request->query() as $k => $v) {
            if(!in_array($k, $filter_keys)) continue;
            $filter[strtolower($k)] = $v;
        }

        $res = $news_aggregator->search($request->query('search_term'), $filter, (int) $request->query('from'));

        $ids = count($res) ? array_map(function($val){
            return $val['_source']['article_id'];
        }, $res['hits']['hits']) : [];

        return Response::json(Article::whereIn('id', $ids)->get());
    }

    public function getArticle(Request $request): JsonResponse
    {
        return Response::json(Article::where('fingerprint', $request->query('hash'))->first());
    }
}
