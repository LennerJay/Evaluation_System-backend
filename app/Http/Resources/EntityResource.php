<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->questionaires) {
            return [
                'questionaires' => QuestionaireResource::collection($this->questionaires)
            ];
        } else {
            return [
                'id' => $this->id,
                'entity_name' => $this->entity_name,
                'questionaires' => QuestionaireResource::collection($this->questionaires)
            ];
        }
    }
}
