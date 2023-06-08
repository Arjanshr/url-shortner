<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShortUrlsController extends Controller
{
    public function create(ShortUrlsRequest $request, ShortUrl $short_url)
    {
        $url = $short_url->create(
            [
                'long_url' => $request->url,
                'short_url' => $this->generateUrl(6),
                'expiration_time' => $this->makeExpirationTime($request->hours, $request->minutes, $request->seconds)
            ]
        );
        return back()->withSuccess([
            'message' => 'Your short url is successfully generaed',
            'short_url' => $url->short_url
        ]);
    }

    public function reroute($code)
    {
        $short_url = ShortUrl::where('short_url',$code)->firstOrFail();
        return $short_url;
    }

    private function makeExpirationTime($hours, $minutes, $seconds)
    {
        $total_seconds = ($hours == null ? 0 : $hours * 60 * 60) + ($minutes == null ? 0 : $minutes * 60) + ($seconds == null ? 0 : $seconds);
        $expirataion_time = Carbon::now()->addSeconds($total_seconds);
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
