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
        $evaluatees = Evaluatee::with(['departments'])->get();
        return  EvaluateeResource::collection($evaluatees);

    }

    public function evaluateeInfo(Request $request)
    {

        $evaluatee = Evaluatee::with([
                                    'klasses' => function($query){
                                        $query->with('subject')
                                            ->with(['sectionYears'=>function($q){
                                                    $q->with('users');
                                            }])
                                            //  ->where('subject_id',5)
                                            ->get();
                                    },
                                    'departments'
                                    ])
                                    ->find($request->evaluatee_id);
        return response()->json( $evaluatee);
    }

    public function evaluated(Request $request)
    {
        $evaluateed = User::with(['evaluatees' => function($query){
                        $query->with(['departments','roles']);
                    }])->findOrFail($request->user_id);
        return  new UserResource($evaluateed);

    }

    public function getEvaluateesToRate(User $user){
        $evaluatees = $user->evaluatees()->with(['roles','departments'])->get();
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


    public function destroy(string $id)
    {
        //
    }
}
