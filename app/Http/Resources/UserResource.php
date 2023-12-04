<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

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
            'department' => $this->whenLoaded('sectionYearsPerUser',function(){
                $departments = [];
                foreach($this->sectionYearsPerUser as $syp){
                    array_push($departments,);
                }
            }),
            'role' => new RoleResource($this->whenLoaded('role')),
            'infos' => new UserInfoResource($this->whenLoaded('userInfo')),
            // 'year_sections' => SectionYearResource::collection($this->whenLoaded('sectionYearsPerUser')),
            'instructors' => $this->whenLoaded('sectionYearDepartments',function(){
                $instructors = [];
                foreach($this->sectionYearDepartments as $syd){
                    foreach($syd->evaluatees as $evaluatee){
                        $instructor = new stdClass;
                        // if(!in_array($evaluatee->name,$instructors)){

                        // }
                        $instructor->id = $evaluatee->id;
                        $instructor->name =  $evaluatee->name;
                        $instructor->name =  $evaluatee->name;
                        $instructor->job_type =  $evaluatee->job_type;

                        array_push($instructors, $instructor);
                    }
                }
                return  $instructors;
            }),


        ];
    }

}
