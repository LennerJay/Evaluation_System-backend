<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\User;
use App\Models\Evaluatee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EvaluateeRequest;
use App\Http\Resources\EvaluateeResource;

class EvaluateeController extends Controller
{
    public function index()
    {
        $evaluatees = Evaluatee::with(['departments','entity'])->latest()->get();


        return  EvaluateeResource::collection($evaluatees);
    }




    public function store(EvaluateeRequest $request)
    {
        if(! Gate::allows('allow-action',auth()->user())){
            abort(403);
        }
        Evaluatee::create([
            'name' => $request->name,
            'entity_id'=>$request->entity_id,
            'job_type' => $request->job_type
        ]);

        return response()->json([
            'message'=>'Successfully created',
            'evaluatees' => $this->index()
        ],200);
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Evaluatee $evaluatee)
    {
        $evaluatee->delete();


        return response()->json(["message"=> "Delete Successfully"],200);
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
