<?php
namespace App\Service\Controller;

use App\Models\Evaluatee;
use App\Models\KlassDetails;
use App\Models\SectionYearDepartment;
use App\Models\Subject;

class ClassService {


    public function saveClass($request)
    {
        $subject = Subject::findOrfail($request->subject_id);
        $evaluatee = Evaluatee::findOrfail($request->evaluatee_id);
        $syd = SectionYearDepartment::firstOrCreate([
            'department_id' => $request->department_id,
            'section_year_id' => $request->s_y_id,
        ]);
        $klass =  KlassDetails::Create([
                's_y_d_id'=> $syd->id,
                'subject_id'=>$subject->id,
                'evaluatee_id'=> $evaluatee->id,
                'time'=>$request->time,
                'day'=>$request->day
                ]);

            return $klass;

        // This code below is used to save many requests
        // foreach($request->datas as $data){
        //     foreach($data['classes'] as $class){
        //         $syd = SectionYearDepartment::where('department_id',$data['department_id'])
        //                                      ->where('section_year_id', $class['s_y_id'])
        //                                      ->first();
        //         foreach($class['subjects'] as $subject){
        //             $sub = Subject::findOrfail($subject['id']);
        //             KlassDetails::create([
        //                 's_y_d_id' => $syd->id,
        //                 'subject_id'=> $sub->id,
        //                 'evaluatee_id' =>$evaluatee->id,
        //                 'time'=> $subject['time'],
        //                 'day' => $subject['day'],
        //             ]);
        //         }
        //     }
        // }


    }

    public function updateClass($request){
        $subject = Subject::findOrfail($request->subject_id);
        $evaluatee = Evaluatee::findOrfail($request->evaluatee_id);
        $syd = SectionYearDepartment::firstOrCreate([
            'department_id' => $request->department_id,
            'section_year_id' => $request->s_y_id,
        ]);
        $class = KlassDetails::findOrfail($request->klass_id);
        $class->s_y_d_id = $syd->id;
        $class->subject_id = $subject->id;
        $class->evaluatee_id = $evaluatee->id;
        $class->time = $request->time;
        $class->day =  $request->day;
        $class->save();
        return $class;
    }


    public function deleteClass($request)
    {
        $class = KlassDetails::findOrfail($request->klass_id);
        $class->delete();
        return 'Deleted successfully';
    }

}
