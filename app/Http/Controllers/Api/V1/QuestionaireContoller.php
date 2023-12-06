<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionaireRequest;
use App\Http\Resources\QuestionaireResource;
use App\Service\Controller\QuestionaireService;

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
            $result = (new QuestionaireService)->saveQuestionaire($request);
            return $this->return_success(QuestionaireResource::make( $result));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Questionaire $questionaire,QuestionaireRequest $request)
    {
        try{

            $result = (new QuestionaireService)->updateQuestionaire($questionaire,$request);
            return $this->return_success($result);

        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function destroy(Questionaire $questionaire)
    {
        try{
            $questionaire->delete();
            return $this->return_success('Successfully deleted');
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
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
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function forEvaluatee(Request $request)
    {
        try{
            $result = (new QuestionaireService)->fetchForEvaluatee($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function latestQuestionaire()
    {
        try{

            $result = (new QuestionaireService)->fetchLatestQuestionaire();
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function withCriterias(Questionaire $questionaire)
    {

        try{
            return $this->return_success($questionaire->load('criterias'));
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }
}
