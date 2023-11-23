<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Department;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EntityResource;
use App\Http\Resources\QuestionaireResource;
use App\Models\Entity;

class QuestionaireContoller extends Controller
{
    public function forEvaluatee(Request $request)
    {

        $questionaire = cache()->remember(
            'questionaire' . $request->entity_id,
            now()->addDay(),
            function() use ($request){
                return Entity::with([
                    'questionaires' =>function($q){
                        $q->with([
                            'criterias' => function($query){
                                $query->with([
                                            'questions' =>function($q){
                                                    $q->select(['id','question','criteria_id']);
                                            }
                                        ])
                                    ->select(['id','description']);
                            }
                        ])
                        ->where('status', '1')
                        ;
                    }
                ])
                ->find($request->entity_id);
            }
        );


        return new EntityResource($questionaire);

    }

    public function latestQuestionaire()
    {
        $questionaires = Questionaire::latest()
                                        ->with([
                                                'criterias' => function($query){
                                                    $query->with([
                                                                'questions' =>function($q){
                                                                        $q->select(['id','question','criteria_id']);
                                                                }
                                                            ])
                                                        ->select(['id','description']);
                                                }
                                        ])
                                        ->select(['id','title','description'])
                                        ->first();
        return response()->json($questionaires);
    }

    public function index()
    {
        $questionaires = Questionaire::with([
                                            'criterias' => function($query){
                                                $query->with([
                                                              'questions' =>function($q){
                                                                    $q->select(['id','question','criteria_id']);
                                                            }
                                                        ])
                                                      ->select(['id','description']);
                                            }
                                       ])
                                       ->select(['id','title','description','semester','school_year','max_respondents','status'])
                                       ->get();
        // return response()->json($questionaires);
        return QuestionaireResource::collection($questionaires);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
