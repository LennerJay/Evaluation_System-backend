<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Controller\RatingService;

class RatingContoller extends Controller
{


    public function store(Request $request)
    {
        try{
            $result = (new RatingService)->saveRatings($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function getRatingsSummary(Request $request)
    {
        try{
            $result = (new RatingService)->ratingsSummary($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }


    public function outcomeRatings (Request $request){
        try{
            $result = (new RatingService)->getOutcomeRatingsSummary($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function getRatingInfo(Request $request)
    {
        try{
            $result = (new RatingService)->fetchRatingInfo($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }
}
