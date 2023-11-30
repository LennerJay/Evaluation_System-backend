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
            'entity_name'=>$this->whenLoaded('entity',function(){
                return $this->entity->entity_name;
            }),
            'departments'=> $this->whenLoaded('evaluateeDepartments',function(){
                    $departments = [];
                    foreach($this->evaluateeDepartments as $eD){
                      array_push($departments ,$eD->department->name);
                    }
                    return $departments;
            }),
            'departments'=> $this->whenLoaded('departments',function(){
                $departments = [];
                foreach($this->departments as $department){
                  array_push($departments ,$department->name);
                }
                return $departments;
            }),
            'klasses'=> $this->whenLoaded('evaluateeDepartments',function(){
                    $klasses = [];
                    foreach($this->evaluateeDepartments as $eD){
                        foreach($eD->klasses as $klass){
                            $class = new stdClass();
                            $class->department = $eD->department->name;
                            $class->subject = $klass->subject->name;
                            $class->sections = [];
                            foreach($klass->sectionYearDepartment  as $section){
                                $sec = new stdClass();
                                 $sec->section_year = $section->sectionYear->s_y;
                                 $sec->time = $section->pivot->time;
                                 $sec->day = $section->pivot->day;
                                array_push($class->sections,$sec);
                            }
                            array_push($klasses,$class);
                        }
                    }
                    return $klasses;
            }),
            'pivot' => $this->whenLoaded('pivot', function(){
                return [
                    'is_done' => $this->pivot->is_done,
                    'rated_on' => $this->pivot->updated_at
                ];
            })
        ];
    }
}
