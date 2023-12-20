<?php

namespace App\Http\Controllers\Api\v1;

use PDOException;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Service\Controller\UserInfoService;
use Exception;
use Illuminate\Support\Facades\Gate;

class UserInfoController extends Controller
{
    public function showDetails(Request $request)
    {
        try{
            $userInfo = (new UserInfoService)->getUserInfo($request);
            return $this->return_success($userInfo);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(UserInfoRequest $request)
    {
        try{
            $result = (new UserInfoService)->updateUserInfo( $request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }

    }

    public function destroy(UserInfo $userInfo)
    {
        if (! Gate::allows('allow-action', auth()->user()->id_number)) {
            abort(403);
        }
        try{
            $userInfo->delete();
            return $this->return_success('Successfully Deleted');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }


}
