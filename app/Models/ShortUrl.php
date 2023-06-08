<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ShortUrl extends Model
{
    use HasFactory;
    protected $fillable = [
        'long_url', 'short_url', 'expiration_time'
    ];

    protected function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => env('APP_URL').'/'.$value,
        );
    }

    public function expiresOn()
    {
        if($this->expiration_time==null) return 'Never';
        $carbonated_date = Carbon::parse($this->expiration_time);
        return $carbonated_date->diffForHumans();
    }
}
