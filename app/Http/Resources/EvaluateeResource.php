<?php

namespace App\Http\Resources;

use stdClass;
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
            'entity_id'=>$this->whenLoaded('entity',function(){
                return $this->entity->id;
            }),
            'entity_name'=>$this->whenLoaded('entity',function(){
                return $this->entity->entity_name;
            }),
            'departments' =>$this->whenLoaded('SectionYearDepartments',function(){
                $departments= [];
                foreach($this->SectionYearDepartments as $syd){
                    if(!in_array($syd->department->name,$departments)){
                        array_push($departments,$syd->department->name);
                    }
                }
                return $departments;
            }),
            'classes' => $this->whenLoaded('KlassDetails',function(){
                $classes = [];
                foreach($this->KlassDetails as $KlassDetail){
                    $class = new stdClass;
                    $class->id = $KlassDetail->id;
                    $class->department = $KlassDetail->sectionYearDepartment->department->name;
                    $class->time = $KlassDetail->time;
                    $class->day = $KlassDetail->day;
                    $class->subject = $KlassDetail->subject->name;
                    $class->section_year = $KlassDetail->sectionYearDepartment->sectionYear->s_y;
                    array_push( $classes,$class);
                }
                return $classes;

            }),
            'instructorsDepartments'=> $this->whenLoaded('KlassDetails',function(){
                $departments = [];
                foreach($this->KlassDetails as $KlassDetail){
                    if(!in_array($KlassDetail->sectionYearDepartment->department->name, $departments)){
                        array_push($departments,$KlassDetail->sectionYearDepartment->department->name);
                    }

                }
                return $departments;
            }),
            'is_done' => $this->whenLoaded('pivot',function(){
                return $this->pivot->is_done;
            }),
            'date_rated' => $this->whenLoaded('pivot',function(){
                if($this->pivot->is_done){
                    return $this->pivot->updated_at->diffForHumans();
                }

            }),
            'users_done_rating'=> $this->users_count
        ];
    }
}
