<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingsSummaryQuestionaire extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'title'=>$this->questionaire->title,
            'description'=>$this->questionaire->description,
            'semester'=>$this->questionaire->semester,
            'school_year'=>$this->questionaire->school_year,
        ];
    }
}
