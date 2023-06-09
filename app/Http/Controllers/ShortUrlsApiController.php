<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShortUrlsApiController extends Controller
{

    public function index()
    {
       return ShortUrlResource::collection(ShortUrl::paginate(5));
    }

    public function store(ShortUrlsRequest $request, ShortUrl $short_url)
    {
        return  $short_url->create(
            [
                'long_url' => $request->url,
                'short_url' => $this->generateUrl(6),
                'expiration_time' => $this->makeExpirationTime($request->hours, $request->minutes, $request->seconds)
            ]
        );
    }

  
    public function destroy(ShortUrl $short_url)
    {
        if($short_url->delete())
        return response()->json(true);
        return response()->json(false);
    }

    private function makeExpirationTime($hours, $minutes, $seconds)
    {
        $total_seconds = ($hours == null ? 0 : $hours * 60 * 60) + ($minutes == null ? 0 : $minutes * 60) + ($seconds == null ? 0 : $seconds);
        if ($total_seconds == 0) $expirataion_time = null;
        else $expirataion_time = Carbon::now()->addSeconds($total_seconds);
        return $expirataion_time;
    }

    private function generateUrl($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $url = '';
        for ($i = 0; $i < $length; $i++) {
            $url .= $characters[random_int(0, $char_length - 1)];
        }
        return $url;
    }
}
