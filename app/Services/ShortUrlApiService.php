<?php
namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShortUrlApiService{

    public function getData(Request $request)
    {
        $urls = ShortUrl::paginate(5);

        if (isset($request->query->all()['search'])) {
            $query = explode('/', request('search'));
            $search = end($query);
            if ($search == '')
                $search = array_slice($query, -2, 1)[0];
            $urls = ShortUrl::where('short_url', 'like', '%' . $search . '%')
                ->Orwhere('long_url', 'like', '%' . request('search') . '%')
                ->paginate(5);
        }
        return $urls;
    }

    public function makeExpirationTime($hours, $minutes, $seconds)
    {
        $total_seconds = ($hours == null ? 0 : $hours * 60 * 60) + ($minutes == null ? 0 : $minutes * 60) + ($seconds == null ? 0 : $seconds);
        if ($total_seconds == 0) $expirataion_time = null;
        else $expirataion_time = Carbon::now()->addSeconds($total_seconds);
        return $expirataion_time;
    }

    public function generateUrl($length = 6)
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