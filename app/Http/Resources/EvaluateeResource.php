<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluateeResource extends JsonResource
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
            'name'=> $this->name,
            'job_type' => $this->job_type,
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'pivot' => $this->whenLoaded('pivot', function(){
                return [
                    'is_done' => $this->pivot->is_done,
                    'rated_on' => $this->pivot->updated_at
                ];
            })
        ];
    }
}
