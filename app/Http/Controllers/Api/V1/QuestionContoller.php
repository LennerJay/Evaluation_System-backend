<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Service\QuestionControllerService\QuestionService;

class QuestionContoller extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Question::class);
    }

    public function store(Request $request)
    {
        try{
            $result = (new QuestionService)->saveQuestion($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Question $question,Request $request)
    {
        try{
            $result = (new QuestionService)->saveQuestion($question,$request);

            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }


    public function destroy(Question $question)
    {
        try{
            $question->delete();
            return $this->return_success('Successfully deleted');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

}
