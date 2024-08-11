<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RezultatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
    
    return [
        'naziv_sobe' => $this->resource->naziv_sobe,
        'ime_igraca' => $this->resource->ime_igraca,
        'trenutni_rezultat' => $this->resource->trenutni_rezultat,

    ];
}
}