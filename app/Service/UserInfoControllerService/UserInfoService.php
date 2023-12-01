<?php

namespace App\Service\UserInfoControllerService;

use App\Models\User;
use App\Models\UserInfo;

class UserInfoService{

    private $userId = null;
    private $request = null;


    public function __construct( $request)
    {
        $validatedData = $request->validate([
            'id_number' => 'numeric|integer|nullable',
        ]);

        if($validatedData){
           $this->userId = $validatedData;

        }else{
            $this->userId = auth()->user()->id_number;
        }
        $this->request = $request;
    }

    public function getUserInfo()
    {

        $userInfo = User::with([
            'userInfo',
            'sectionYearDepartment' => function($q){
                $q->with(['department','sectionYear']);
            }
            ])->findOrfail( $this->userId);

            return $userInfo ;
    }


    public function updateUserInfo()
    {
        $user = UserInfo::firstOrCreate([
            'user_id' => $this->userId
        ]);

        $user->first_name= $this->request['first_name'];
        $user->middle_name= $this->request['middle_name'];
        $user->last_name= $this->request['last_name'];
        $user->mobile_number= $this->request['mobile_number'];
        $user->course= $this->request['course'];
        $user->email= $this->request['email'];
        $user->regular= $this->request['regular'];
        $user->save();

        return $user;
    }

}
