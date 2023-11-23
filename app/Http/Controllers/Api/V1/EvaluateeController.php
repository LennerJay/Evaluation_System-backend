<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Evaluatee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluateeResource;
use App\Http\Resources\UserResource;

class EvaluateeController extends Controller
{
    public function index()
    {
        $evaluatees = Evaluatee::with(['departments','entity'])->get();
        return  EvaluateeResource::collection($evaluatees);
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

    public function getEvaluateesToRate(User $user){


        $evaluatees = $user->evaluatees()->with(['entity','departments'])->get();
        // return response()->json( $evaluatees);
        return EvaluateeResource::collection($evaluatees);
    }
    public function create()
    {
        //
    }

    public function show(Request $request)
    {
        //
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
}
