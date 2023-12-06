<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Service\Controller\UserService;


class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }


    public function index()
    {
        try{
            $users = (new UserService)->fetchAllUsers();
            return $this->return_success($users);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(Request $request)
    {
        try{

            $result = (new UserService)->saveManyStudentsBySection($request->only('department_id','s_y_id','ids','role_id'));
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }


    public function update(User $user,Request $request)
    {

        try{
            $result = (new UserService)->updateIdNumber($user,$request->only('id_number'));
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return $this->return_success('Deleted successfully');
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }


    public function getUserInfos()
    {
        $user = cache()->remember(
            'getUserInfo' . auth()->user()->id_number,
            now()->addDay(),
            function(){
            return  User::with([
                'department',
                'role',
                'userInfo',
                'sectionYearsPerUser.klasses',
                'sectionYearsPerUser.klasses.evaluatee',
                'sectionYearsPerUser.klasses.subject',
            ])->findOrFail(auth()->user()->id_number);
            }
        );
        return new UserResource($user);

    }

    public function getUser()
    {

        $user = cache()->remember(
            'getUser'. auth()->user()->id_number,
            now()->addDay(),
            function(){
                return User::with('role')
                ->findOrFail(auth()->user()->id_number);
            }
        );
        // return response()->json($user);
        return new UserResource($user);
    }

    public function getEvaluateesToRate(){
        try{
            $result = collect((new UserService)->fetchEvaluateesToRate());
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function resetPassword(User $user)
    {
        $this->authorize('update', $user);
        try{
            $result = (new UserService)->resetPassword($user);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }

    }

    public function changePassword(Request $request)
    {
        try{
            $result = (new UserService)->changePassword( $request->only('id_number','password'));
            return $this->return_success( $result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }
}
