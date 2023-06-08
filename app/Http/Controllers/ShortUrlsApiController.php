<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlsRequest;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShortUrlsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return ShortUrlResource::collection(ShortUrl::get());
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
