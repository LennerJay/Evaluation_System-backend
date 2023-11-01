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
            'name'=> $this->name,
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
