<?php
namespace App\Service\Controller;

use App\Models\Entity;
use App\Models\Questionaire;
use App\Http\Resources\EntityResource;
use App\Http\Resources\QuestionaireResource;


 class QuestionaireService {


    public function saveQuestionaire($request)
    {
        $questionaire = Questionaire::create([
            'title' => $request->title,
            'description' => $request->description,
            'semester' => $request->semester,
            'school_year' => $request->school_year,
            'max_respondents' => $request->max_respondents,
            'status' =>$request->status
           ]);
            $questionaire->entities()->attach($request->entity_id);

           return QuestionaireResource::make($questionaire);
    }

    public function updateQuestionaire($questionaire,$request)
    {
        $questionaire->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'semester' =>$request->semester,
            'school_year'=>$request->school_year,
            'max_respondents'=>$request->max_respondents,
            'status'=>$request->status
        ]);

        return QuestionaireResource::make($questionaire);
    }

    public function fetchForEvaluatee($request)
    {
        // $questionaire = cache()->remember(
        //     'questionaire' . $request->entity_id,
        //     now()->addDay(),
        //     function() use ($request){
        //         return Entity::with([
        //             'questionaires' =>function($q){
        //                 $q->with([
        //                     'criterias' => function($query){
        //                         $query->with('questions');
        //                     }
        //                 ])
        //                 ->where('status', true)
        //                 ->latest('updated_at')
        //                 ->first();
        //             }
        //         ])
        //         ->find($request->entity_id);
        //     }
        // );
       $questionaire = Entity::with([
            'questionaires' =>function($q){
                $q->with([
                    'criterias' => function($query){
                        $query->with('questions');
                    }
                ])
                ->where('status', true)
                ->latest('updated_at')
                ->first();
            }
        ])
        ->find($request->entity_id);
        // $entity = Entity::with('questionaires')->findOrfail($request->entity_id);
        // return new EntityResource($questionaire);
        return $questionaire;

    }

    public function fetchLatestQuestionaire()
    {
        $questionaires = Questionaire::latest()
                                        ->with([
                                                'criterias' => function($query){
                                                    $query->with('questions');
                                                }
                                        ])
                                        ->get();
        return QuestionaireResource::collection($questionaires);
    }

 }
