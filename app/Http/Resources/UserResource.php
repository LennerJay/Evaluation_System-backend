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
            'role_name' => $this->whenLoaded('role',function(){
                return $this->role->name;
            }),
            'infos' => new UserInfoResource($this->whenLoaded('userInfo')),
            'departments' => $this->whenLoaded('sectionYearDepartments',function(){
                $departments = [];

                foreach($this->sectionYearDepartments as $syd){
                    if(!in_array($syd->department->name,$departments)){
                        array_push($departments,$syd->department->name);
                    }

                }

                return $departments;
            }),
            'year_section' => $this->whenLoaded('sectionYearDepartments',function(){
                $yearSections = [];
                foreach($this->sectionYearDepartments as $syd){
                    array_push($yearSections,$syd->sectionYear->s_y);
                }

                return $yearSections;
             }),

        ];
    }

}
