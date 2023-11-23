<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionYearResource extends JsonResource
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
            'year_section' => $this->s_y,
            'pivot' => $this->whenLoaded('pivot', function(){
                return [
                    'is_done' => $this->pivot->is_done,
                    'rated_on' => $this->pivot->updated_at
                ];
            }),
            'classes' => KlassesResource::collection($this->whenLoaded('klasses')),

        ];
    }
}
