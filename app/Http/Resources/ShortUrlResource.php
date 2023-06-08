<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'long_url' => $this->long_url,
            'short_url' => $this->short_url,
            'expiration_time' => $this->expiration_time,
            'expires_on' => $this->expiresOn(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
