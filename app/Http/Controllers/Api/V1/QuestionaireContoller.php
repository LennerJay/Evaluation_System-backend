<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\Entity;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Requests\QuestionaireRequest;
use App\Http\Resources\QuestionaireResource;

class QuestionaireContoller extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Questionaire::class,'questionaire',['except'=>['withCriterias']]);
    }


    public function index()
    {
        return $this->return_success(QuestionaireResource::collection(Questionaire::all()));
    }

    public function store(QuestionaireRequest $request)
    {

        try{
            $questionaire =  Questionaire::create([
                'title' => $request->title,
                'description' => $request->description,
                'semester' => $request->semester,
                'school_year' => $request->school_year,
                'max_respondents' => $request->max_respondents,
                'status' =>$request->status
               ]);
                $questionaire->entities()->attach($request->entity_id);
                return $this->return_success(QuestionaireResource::make($questionaire));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Questionaire $questionaire,QuestionaireRequest $request)
    {
        try{
            $questionaire->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'semester' =>$request->semester,
                'school_year'=>$request->school_year,
                'max_respondents'=>$request->max_respondents,
                'status'=>$request->status
            ]);

            return $this->return_success(QuestionaireResource::make($questionaire));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Questionaire $questionaire)
    {
        try{
            $questionaire->delete();
            return $this->return_success('Successfully deleted');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }


    }


    public function questionaireForm()
    {
        $questionaires = Questionaire::with([
                                            'criterias' => function($query){
                                                $query->with(['questions']);
                                            }
                                       ])
                                       ->get();
        return QuestionaireResource::collection($questionaires);
    }

    public function updateStatus(Request $request,Questionaire $questionaire)
    {
        $this->authorize('update', $questionaire);
        try {
            if($request->update_time){
                $questionaire->updated_at =  $request->update_time;

            }else{
                $questionaire->status =  !$questionaire->status;
            }
            $questionaire->save();
            return $this->return_success($questionaire);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

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
                                $query->with('questions');
                            }
                        ])
                        ->where('status', true)
                        ->latest('updated_at')
                        ->first();
                    }
                ])
                ->find($request->entity_id);
            }
        );

        return new EntityResource($questionaire);

    }

    public function latestQuestionaire()
    {
        try{
            $questionaires = Questionaire::latest()
                            ->with([
                                    'criterias' => function($query){
                                        $query->with('questions');
                                    }
                            ])
                            ->get();

            return $this->return_success(QuestionaireResource::collection($questionaires));

        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function withCriterias(Request $request)
    {
        try{

            $questionaire = Questionaire::findOrFail($request->id);
            return $this->return_success($questionaire->with('criterias')->get());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }
}
