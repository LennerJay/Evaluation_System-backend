<?php
namespace App\Service\EvaluateeControllerService;

use App\Models\Evaluatee;
use App\Http\Resources\EvaluateeResource;


class EvaluateeService{

    public function fetchEvaluateInfo($id){
        $evaluatee = Evaluatee::with([
            'evaluateeDepartments' =>function($query){
                $query->with('department')
                      ->with([
                        'klasses'=>function($q){
                            $q->with([
                                'subject',
                                'sectionYearDepartment'
                                => function($q){
                                    $q->with('sectionYear');
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

    public function fetchAllEvaluatees()
    {
        $evaluatees = Evaluatee::with([
            'departments','entity'])->latest()->get();
        return  EvaluateeResource::collection($evaluatees);
    }

    public function saveEvaluatees($request)
    {
        $evaluate = Evaluatee::create([
            'name' => $request->name,
            'job_type'=>$request->job_type,
            'entity_id'=>$request->entity_id
        ]);

        return EvaluateeResource::make($evaluate);

    }

    public function updateEvaluatee($evaluatee, $request)
    {
        $evaluatee->name = $request->name;
        $evaluatee->job_type = $request->job_type;
        $evaluatee->entity_id = $request->entity_id;
        $evaluatee->save();
        return $evaluatee;

    }


}
