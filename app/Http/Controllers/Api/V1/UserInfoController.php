<?php

namespace App\Http\Controllers\Api\v1;

use PDOException;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Service\UserInfoControllerService\UserInfoService;
use Exception;

class UserInfoController extends Controller
{
    // private $userId=null;
    public function __construct()
    {
        $this->authorizeResource(UserInfo::class);
    }
    public function showDetails(Request $request)
    {
        try{
            $userInfo = (new UserInfoService($request))->getUserInfo();
            return $this->return_success($userInfo);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store( UserInfoRequest $request)
    {
        try{
            // $result = (new UserInfoService($request))->updateUserInfo();
            // return $this->return_success($result);
            return $this->return_success('test');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }

    }



    public function destroy(UserInfo $userInfo)
    {
        try{

        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }




}
