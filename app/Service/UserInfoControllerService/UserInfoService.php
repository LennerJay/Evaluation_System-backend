<?php

namespace App\Service\UserInfoControllerService;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserInfo;

class UserInfoService{

    public function getUserInfo($request)
    {
        $userid = null;
        if($request->id_number){
            $userid = $request->id_number;
        }
        else{
            $userid = auth()->user()->id_number;
        }
        $userInfo = User::with([
            'userInfo',
            'sectionYearDepartment' => function($q){
                $q->with([
                    'department',
                    'sectionYear',
                    'klasses' =>function($q){
                        $q->with([
                            'subject',
                            'evaluateeDepartment'=>function($q){
                                $q->with([
                                    'department',
                                    'evaluatee'
                                ]);
                            }
                        ]);
                    }
                ]);
            }
            ])->findOrfail($userid );

            // return UserResource::make($userInfo) ;
            return$userInfo ;
    }


    public function updateUserInfo($request)
    {
        $user = UserInfo::firstOrCreate([
            'user_id' => $request['id_number']
        ]);

        $user->first_name= $request['first_name'];
        $user->middle_name= $request['middle_name'];
        $user->last_name= $request['last_name'];
        $user->mobile_number= $request['mobile_number'];
        $user->course= $request['course'];
        $user->email= $request['email'];
        $user->regular= $request['regular'];
        $user->save();
        return $user;

    }
}
