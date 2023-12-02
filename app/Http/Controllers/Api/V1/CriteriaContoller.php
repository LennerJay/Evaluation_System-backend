<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\Criteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Http\Resources\CriteriaResource;

class CriteriaContoller extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Criteria::class,'criteria');
    }

    public function index()
    {
        return $this->return_success(CriteriaResource::collection(Criteria::all()));
    }


    public function withQuestions(Criteria $criteria)
    {
        try{
            return $this->return_success($criteria->load('questions'));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }

    }


    public function store(CriteriaRequest $request)
    {
        try{
            $criteria = Criteria::create([
                'description' => $request->description
            ]);
            return $this->return_success(CriteriaResource::make($criteria));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }


    public function update(CriteriaRequest $request, Criteria $criteria)
    {
        try{
            $criteria->description = $request->description;
            $criteria->save();
            return $this->return_success($criteria);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }


    public function destroy(Criteria $criteria)
    {
        try{
            $criteria->delete();
            return $this->return_success('Successfully deleted');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }
}
