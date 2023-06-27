<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use App\Models\NewsCategory;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use App\Services\NewsAggregator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    function addInterest(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'group_name' => ['required'],
            'group_id' => ['required'],
        ]);

        $parent_category = match ($request->group_name) {
            'news_authors' => NewsAuthor::find($request->group_id),
            'news_sources' => NewsSource::find($request->group_id),
            'news_category' => NewsCategory::find($request->group_id),
            default => null
        };

        $exists = UserInterest::where(['user_id' => $user->id, 'interest_id' => $parent_category->id])->exists();

        if($exists) return Response::json(['message' => 'interest already exists'], 400);

        $user_interest = UserInterest::create([
            'user_id' => $user->id,
            'interest_id' => $parent_category->id,
            'interest_type' => get_class($parent_category)
        ]);

        if($user_interest) {
            return Response::json($user_interest->load('parentInterest'));
        }

        return Response::json(['message' => 'unable to add interest'], 400);
    }

    function getUserInterests(Request $request): JsonResponse
    {
        $user = $request->user();

        return Response::json(UserInterest::where('user_id', $request->user()->id)->with('parentInterest')->get());
    }

    function removeInterest(Request $request, string $id): JsonResponse
    {
        $user = $request->user();

        $interest = UserInterest::find($id);

        if($interest && $interest->user_id === $user->id) {

            $interest->delete();

            return Response::json(null);
        }

        return Response::json(['message' => 'unable to delete interest'], 400);
    }

    function getUserNewsFeed(Request $request, NewsAggregator $news_aggregator): JsonResponse
    {
        $user = $request->user();

        $interests = $user->interests->map(function($interest) {
            return $interest->parentInterest->name;
        })->toArray();

        $res = $news_aggregator->getUserNewsFeed($interests, (int) $request->query('from'));

        if($res['hits']['hits']) {

            $ids = array_map(function($val){
                return $val['_source']['article_id'];
            }, $res['hits']['hits']);

            if(count($ids)) return Response::json(Article::whereIn('id', $ids)->get());
        }

        return Response::json($res, 400);
    }
}
