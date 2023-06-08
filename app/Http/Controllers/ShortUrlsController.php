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
        $short_url = ShortUrl::where('short_url', $code)->first();
        if($short_url==null) return response('This url has been deleted', 410);
        $is_expired = $this->checkIfExpired($short_url->expiration_time);
        if(!$is_expired) return redirect($short_url->long_url,302);
        else abort(419);
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


    private function checkIfExpired($time)
    {
        if ($time == null) return false;
        $end_time = Carbon::parse($time);
        $now_time = Carbon::now();
        if ($end_time->gt($now_time)) return false;
        return true;
    }
}
