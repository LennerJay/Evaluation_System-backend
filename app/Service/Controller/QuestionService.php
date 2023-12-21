<?php
namespace App\Service\Controller;

use App\Models\Question;

class QuestionService{

    public function saveQuestion($request)
    {
        $question = Question::create(
            [
                'question' => $request->question,
                'criteria_id' => $request->criteria_id
            ]
        );

        return $question;
    }

    public function updateQuestion($question, $request)
    {
        $question->question = $request->question;
        $question->save();

        return $question;
    }


}
