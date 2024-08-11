<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OdgovorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
    
    return [
        'ID' => $this->resource->id,
        'Pitanje' => new PitanjeResource($this->resource->pitanje),
        'Tekst_odgovora' => $this->resource->tekst_odgovora,
        'Tacan_odgovor' => $this->resource->tacan_odgovor,
    ];
}
}