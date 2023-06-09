<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ShortUrlsController extends Controller
{
    public function index(Request $request)
    {
        // $query = explode('/', request('search'));
        //     $search = end($query);
        //     if ($search == '')
        //         $search = array_slice($query, -2, 1);
        //         return $search;
        $url = env('APP_URL') . '/api/short-url';
        $request = Request::create($url, 'GET');
        // dd(Route::dispatch($request));
        $urls = Route::dispatch($request)->getData();
        return view('urls.index', compact('urls'));
    }

    public function create(ShortUrlsRequest $request, ShortUrl $short_url)
    {
        $url = env('APP_URL') . '/api/short-url';

        $post_request = Request::create($url, 'POST', $request->toArray());

        $response = Route::dispatch($post_request,$short_url);
        return back()->withSuccess([
            'message' => 'Your short url is successfully generaed',
            'short_url' => $response->getData()->short_url
        ]);
    }

    public function destroy($short_url)
    {
        $url = env('APP_URL') . '/api/short-url/'.$short_url;
        $request = Request::create($url, 'DELETE');
        $response = Route::dispatch($request);
        if($response)
        return back()->withSuccess([
            'message' => 'Your short url is successfully deleted',
        ]);
    }
    public function reroute($code)
    {
        $short_url = ShortUrl::where('short_url', $code)->first();
        if ($short_url == null) return response('This url has been deleted', 410);
        $is_expired = $this->checkIfExpired($short_url->expiration_time);
        if (!$is_expired) return redirect($short_url->long_url, 302);
        else abort(419);
    }


    private function checkIfExpired($time)
    {
        if ($time == null) return false;
        $end_time = Carbon::parse($time);
        $now_time = Carbon::now();
        if ($end_time->gt($now_time)) return false;
        return true;
    }
}
