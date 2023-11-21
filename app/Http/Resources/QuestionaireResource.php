<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionaireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' =>$this->id,
            'title' =>$this->title,
            'description' =>$this->description,
            'semester' =>$this->semester,
            'school_year' =>$this->school_year,
            'max_respondents' =>$this->max_respondents,
            'status' =>$this->status,
            'criterias' => CriteriaResource::collection($this->whenLoaded('criterias')),

        ];
    }
}
