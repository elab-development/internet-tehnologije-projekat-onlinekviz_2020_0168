<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PitanjeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id, 
            'tekst_pitanja' => $this->resource->tekst_pitanja,
            'odgovori' => OdgovorResource::collection($this->whenLoaded('odgovori')),
        ];
    }
}
