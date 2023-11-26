<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Throwable;
use App\Models\User;
use App\Models\Evaluatee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EvaluateeRequest;
use App\Http\Resources\EvaluateeResource;
use App\Models\Klass;
use App\Models\SectionYear;

class EvaluateeController extends Controller
{
    public function index()
    {
        $evaluatees = Evaluatee::with([
            'departments'=>function($q){
                $q->distinct();
            }
            ,'entity'])->latest()->get();
        return  EvaluateeResource::collection($evaluatees);
    }




    public function store(EvaluateeRequest $request)
    {

        // try{
        //     $isEvaluateeExist = Evaluatee::where('name', $request->name)->exists();
        //     if(!$isEvaluateeExist){
        //         $evaluatee =  Evaluatee::create([
        //             'name' => $request->name,
        //             'entity_id'=>$request->entity_id,
        //             'job_type' => $request->job_type
        //         ]);
        //         $evaluatee->departments()->attach($request->department_id);

        //         if($request->classes){
        //             foreach($request->classes as $class){
        //              $evaluatee->subjects()->attach($class['subject']['id']);
        //              $klass = Klass::where('evaluatee_id', $evaluatee->id)
        //                             ->where('subject_id',$class['subject']['id'])
        //                             ->first();;
        //                 foreach( $class['schedules'] as $schedule){
        //                     $klass->sectionYears()->attach($schedule['sectionYear']['id'],['time'=>$schedule['time'],'day'=>$schedule['day']]);
        //                 }

        //             // $klass->load('sectionYears');
        //             }
        //         }
        //     }else{
        //         return response()->json(['message' => 'Name already exists'], 400);
        //     }

        //     return response()->json([
        //         'message'=>'Successfully created',
        //         'evaluatees' => $this->index()
        //     ],200);

        // }catch(Exception $e){
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ]);
        // }
        // gettype($request->classes[0]['subject'])
        $isEvaluateeExist = Evaluatee::where('name', $request->name)->first();

        return response()->json($isEvaluateeExist);

    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Evaluatee $evaluatee)
    {
        $evaluatee->delete();

        return response()->json([
            "message"=> "Delete Successfully",
            "evaluatees" => $this->index(),
        ],200);
    }

    public function evaluateeInfo(Request $request)
    {

        $evaluatee = Evaluatee::with([
                                    'klasses' => function($query){
                                        $query->with('subject')
                                            ->with(['sectionYears'=>function($q){
                                                    $q->withCount('sectionYearsPerUser');
                                            }])
                                            ->get();
                                    },
                                    'departments',
                                    'entity'
                                    ])
                                    ->findOrFail($request->evaluatee_id);


        return response()->json($evaluatee);
    }

    public function evaluated(Request $request)
    {
        $evaluateed = User::with(['evaluatees' => function($query){
                        $query->with(['departments','roles']);
                    }])->findOrFail($request->user_id);
        return  new UserResource($evaluateed);

    }

    public function getEvaluateesToRate(User $user)
    {
        $evaluatees = $user->evaluatees()->with(['entity','departments'])->get();


        // return response()->json( $evaluatees);
        return EvaluateeResource::collection($evaluatees);
    }
}
