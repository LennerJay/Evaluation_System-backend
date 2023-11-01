<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_number' => $this->id_number,
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'info' => UserInfoResource::make($this->whenLoaded('userInfo')),
            'evaluatees' => EvaluateeResource::collection($this->whenLoaded('evaluatees')),
        ];
    }

}