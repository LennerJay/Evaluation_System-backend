<?php

namespace App\Http\Controllers\Api\v1;

use PDOException;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use Exception;

class UserInfoController extends Controller
{
    public function showDetails(Request $request)
    {
        $validatedData = $request->validate([
            'id_number' => 'numeric|integer|nullable',
        ]);

        if($validatedData){
           $userId = $validatedData;

        }else{
            $userId = auth()->user()->id_number;
        }




        try{
            $userInfo = User::with('userInfo')->findOrfail( $userId);
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }

        return $this->return_success($userInfo);

    }

    public function store(UserInfoRequest $request)
    {
        try{

            $userInfo = UserInfo::create([
                'user_id' => $request->user_id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'course' => $request->course,
                'email' => $request->email,
                'regular' => $request->regular
            ]);
            return $this->return_success($userInfo);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }

    }

    public function update(UserInfoRequest $request, string $id)
    {
        try{

        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }
}
