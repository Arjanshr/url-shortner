<?php
namespace App\Services;

use App\Http\Requests\ShortUrlsRequest;
use App\Models\ShortUrl;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ShortUrlService{
    // public $url = env('APP_URL') . '/api/short-url';

    public function checkIfExpired($time)
    {
        if ($time == null) return false;
        $end_time = Carbon::parse($time);
        $now_time = Carbon::now();
        if ($end_time->gt($now_time)) return false;
        return true;
    }

    public function getData()
    {
        $url = env('APP_URL') . '/api/short-url';
        $request = Request::create($url, 'GET');
        return Route::dispatch($request)->getData();
    }

    public function makeShortUrl(ShortUrlsRequest $request)
    {
        $url = env('APP_URL') . '/api/short-url';
        $short_url = new ShortUrl();
        $post_request = Request::create($url, 'POST', $request->toArray());
        return Route::dispatch($post_request,$short_url);
    }

    public function deleteShortUrl($short_url)
    {
        $url = env('APP_URL') . '/api/short-url/' . $short_url;
        $request = Request::create($url, 'DELETE');
        return Route::dispatch($request);
    }
}