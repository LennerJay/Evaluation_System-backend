<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\User;
use App\Models\Evaluatee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EvaluateeRequest;
use App\Http\Resources\EvaluateeResource;
use App\Service\Controller\EvaluateeService;

class EvaluateeController extends Controller
{
    public function index()
    {
        try{
            $result = (new EvaluateeService)->fetchAllEvaluatees();
            return $this->return_success( $result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }




    public function store(EvaluateeRequest $request)
    {
        try{
            $isEvaluateeExist = Evaluatee::where('name', $request->name)->exists();

            if($isEvaluateeExist){
                return $this->return_error('Name Already Exists');
            }
            $result = (new EvaluateeService)->saveEvaluatees($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }


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


    }

    public function update(Evaluatee $evaluatee,EvaluateeRequest $request)
    {
        try{
            $result = (new EvaluateeService)->updateEvaluatee($evaluatee, $request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }


    public function destroy(Evaluatee $evaluatee)
    {
        if(!Gate::allows('allow-action')){
            return $this->return_error('You are not allowed to do this action');
        }
        try{
            $evaluatee->delete();
            return $this->return_success("Delete Successfully");
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function evaluateeInfo(Request $request)
    {
        try{

            $result = (new EvaluateeService)->fetchEvaluateInfo($request->evaluatee_id);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function evaluated(Request $request)
    {
        $evaluatees = User::with(['evaluatees' => function($query){
                        $query->with(['departments','roles']);
                    }])->findOrFail($request->user_id);
        return  new UserResource($evaluatees);

    }
}
