<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Http\Resources\SubjectResource;

class SubjectController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Subject::class, 'subject');
    }

    public function index()
    {
        $subject = cache()->remember(
            'allSubjects',
            now()->addDay(),
            function(){
                return Subject::all();
            }
        );

        return $this->return_success(SubjectResource::collection($subject));
        // return response()->json(Subject::all());
    }

    public function store(SubjectRequest $request)
    {
        try{

            $subject = Subject::create([
                'name' => $request->name
            ]);

            return $this->return_success($subject);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }



    public function update(SubjectRequest $request, Subject $subject)
    {
        try{

            $subject->name = $request->name;
            $subject->save();
            return $this->return_success($subject);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Subject $subject)
    {
        try{
            $subject->delete();
            return $this->return_success('Deleted successfully');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }
}
