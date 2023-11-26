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
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'role' => new RoleResource($this->whenLoaded('role')),
            'infos' => new UserInfoResource($this->whenLoaded('userInfo')),
            'year_sections' => SectionYearResource::collection($this->whenLoaded('sectionYearsPerUser')),
        ];
    }

}
