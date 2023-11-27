<?php
namespace App\Service\EvaluateeControllerService;

use App\Models\Evaluatee;


class EvaluateeService{
    public function fetchEvaluateInfo($id){
        $evaluatee = Evaluatee::with([
            'evaluateeDepartments' =>function($query){
                $query->with('department')
                      ->with([
                        'klasses'=>function($q){
                            $q->with([
                                'subject',
                                'klassSections' => function($q){
                                    $q->with([
                                        'sectionYearDepartment' => function($q){
                                            $q->with('sectionYear');
                                        }
                                    ]);
                                }
                            ]);
                        }
                      ]);
                ;
            },
            'entity',
            ])
            ->findOrFail($id);

        return $evaluatee;
    }


}
