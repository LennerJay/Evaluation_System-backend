<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question' => $this->whenLoaded('question',function(){
                return $this->question->question;
            }),
            'departments' => $this->whenLoaded('user',function(){
                $departments = [];
                foreach($this->user->sectionYearDepartments as $syd){
                    if(!in_array($syd->department->name,$departments)){
                        array_push($departments,$syd->department->name);
                    }
                }
                return $departments;
            }),
            'year_section' => $this->whenLoaded('user',function(){
                $yearSections = [];
                foreach($this->user->sectionYearDepartments as $syd){
                    array_push($yearSections,$syd->sectionYear->s_y);
                }
                return $yearSections;
             }),
             'fullName' =>$this->whenLoaded('user',function(){
                return $this->user->userInfo->first_name . ' ' . $this->user->userInfo->middle_name . ' ' . $this->user->userInfo->last_name
                ;
             }),
             'rating'=> $this->rating
        ];
    }
}
