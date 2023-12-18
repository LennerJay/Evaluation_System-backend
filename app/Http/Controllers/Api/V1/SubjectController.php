<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Subject;
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
        return $this->return_success(SubjectResource::collection(Subject::latest()->get()));
    }

    public function store(SubjectRequest $request)
    {
        try{

            $exist = Subject::where('name', $request->name)->exists();
            if( $exist ){
                return $this->return_success(false);
            }
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

            $exist = Subject::where('name', $request->name)->exists();
            if( $exist ){
                return $this->return_success(false);
            }
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
