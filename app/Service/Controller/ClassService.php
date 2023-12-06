<?php
namespace App\Service\Controller;

use App\Models\Evaluatee;
use App\Models\KlassDetails;
use App\Models\SectionYearDepartment;
use App\Models\Subject;

class ClassService {


    public function saveClass($request)
    {
        $evaluatee = Evaluatee::findOrfail($request->evaluatee_id);

        foreach($request->datas as $data){
            foreach($data['classes'] as $class){
                $syd = SectionYearDepartment::where('department_id',$data['department_id'])
                                             ->where('section_year_id', $class['s_y_id'])
                                             ->first();
                foreach($class['subjects'] as $subject){
                    $sub = Subject::findOrfail($subject['id']);
                    KlassDetails::create([
                        's_y_d_id' => $syd->id,
                        'subject_id'=> $sub->id,
                        'evaluatee_id' =>$evaluatee->id,
                        'time'=> $subject['time'],
                        'day' => $subject['day'],
                    ]);
                }
            }
        }

        return 'Suceesfully created';
    }

    public  function updateClass($request)
    {

    }

    public function deleteClass($request)
    {
        $class = KlassDetails::findOrfail($request->id);
        $class->delete();
        return 'Deleted successfully';
    }

}
