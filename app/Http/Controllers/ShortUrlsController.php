<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Models\ShortUrl;
use App\Services\ShortUrlService;
class ShortUrlsController extends Controller
{
    public function __construct(private ShortUrlService $short_url_service)
    {
    }

    public function index()
    {
        $urls = $this->short_url_service->getData();
        return view('urls.index', compact('urls'));
    }

    public function create(ShortUrlsRequest $request)
    {
        $response = $this->short_url_service->makeShortUrl($request);
        return back()->withSuccess([
            'message' => 'Your short url is successfully generaed',
            'short_url' => $response->getData()->short_url
        ]);
    }

    public function destroy($short_url)
    {
        $response = $this->short_url_service->deleteShortUrl($short_url);
        if ($response){
            return back()->withSuccess([
                'message' => 'Your short url is successfully deleted',
            ]);
        }
    }

    public function reroute($code)
    {
        $short_url = ShortUrl::where('short_url', $code)->first();
        if ($short_url == null) return response('This url has been deleted or does not exist', 410);
        $is_expired = $this->short_url_service->checkIfExpired($short_url->expiration_time);
        if (!$is_expired) return redirect($short_url->long_url, 302);
        else abort(419);
    }
}
