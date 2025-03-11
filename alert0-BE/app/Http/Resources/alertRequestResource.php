<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class alertRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return[
        'id'             => $this->id,
        'user_id'        => $this->user_id,
        'request_type'   => $this->request_type,
        'request_status' => $this->request_status,
        'request_date'   => $this->request_date,
        'longitude'      => $this->longitude,
        'latitude'       => $this->latitude,
        'created_at'     => $this->created_at,
      ];
    }
}
