<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KlassesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'subject' => SubjectResource::make($this->whenLoaded('subject')),
            'evaluatee' =>EvaluateeResource::make($this->whenLoaded('evaluatee')),
            'subject_id' => $this->subject_id,
            'evaluatee_id' => $this->evaluatee_id,
            'schedule' => $this->whenLoaded('pivot',function(){
                return [
                    'time' => $this->pivot->time,
                    'day' => $this->pivot->day,
                ];
            }),
        ];
    }
}
