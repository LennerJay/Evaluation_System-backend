<?php

namespace App\Http\Resources;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_number' => $this->whenLoaded('user',function(){
                return $this->user->id_number;
            }),
            'fullname' => $this->first_name . ' '.$this->middle_name .' '. $this->last_name,
            'mobile_number' => $this->mobile_number,
            'course' => $this->course,
            'email' => $this->email,
            'role_name' => $this->whenLoaded('user',function(){
                return $this->user->role->name;
            }),
            'departments'=> $this->whenLoaded('user',function(){
                $departments = [];
                foreach($this->user->sectionYearDepartments as $syd){
                    if(!in_array($syd->department->name,$departments)){
                        array_push($departments,$syd->department->name);
                    }
                }
                return $departments;
            }),
            'section_years'=> $this->whenLoaded('user',function(){
                $sy = [];
                foreach($this->user->sectionYearDepartments as $syd){
                    if(!in_array($syd->sectionYear->s_y,$sy)){
                        array_push($sy,$syd->sectionYear->s_y);
                    }
                }
                return $sy;
            }),
            'classes'=> $this->whenLoaded('user',function(){
                $classes = [];
                foreach($this->user->sectionYearDepartments as $syd){
                    foreach($syd->KlassDetails as $classDetails){
                        $class = new stdClass;
                        $class->department = $syd->department->name;
                        $class->section_year =$syd->sectionYear->s_y;
                        $class->evaluatee_id = $classDetails->evaluatee->id;
                        $class->evaluatee_name = $classDetails->evaluatee->name;
                        $class->subject = $classDetails->subject->name;
                        $class->time = $classDetails->time;
                        $class->day = $classDetails->day;
                        array_push( $classes,$class);
                    }

                }


                return $classes;

             }),
        ];
    }
}
