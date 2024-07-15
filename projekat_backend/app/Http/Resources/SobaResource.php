<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SobaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->resource->id,
            'Maksimalan_broj_igraca' => $this->resource->maksimalan_broj_igraca,
            'Status' => $this->resource->status,
            'naziv_sobe'=> $this->resource->naziv_sobe
        ];
    }


}