<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use App\Services\ShortUrlApiService;
use Illuminate\Http\Request;

class ShortUrlsApiController extends Controller
{
    public function __construct(private ShortUrlApiService $short_url_api_service)
    {
    }

    public function index(Request $request)
    {
        $urls = $this->short_url_api_service->getData($request);
        return ShortUrlResource::collection($urls);
    }

    public function store(ShortUrlsRequest $request, ShortUrl $short_url)
    {
        return  $short_url->create(
            [
                'long_url' => $request->url,
                'short_url' => $this->short_url_api_service->generateUrl(6),
                'expiration_time' => $this->short_url_api_service->makeExpirationTime($request->hours, $request->minutes, $request->seconds)
            ]
        );
    }


    public function destroy(ShortUrl $short_url)
    {
        if ($short_url->delete()) {
            return response()->json(true);
        }
        return response()->json(false);
    }
}
