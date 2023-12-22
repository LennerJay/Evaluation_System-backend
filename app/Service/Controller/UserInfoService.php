<?php

namespace App\Service\Controller;

use App\Http\Resources\FetchingInfoResource;
use App\Http\Resources\UserInfoResource;
use App\Models\UserInfo;

class UserInfoService{

    public function getUserInfo($request)
    {
        if($request->id_number){
            $userInfo = UserInfo::with([
                'user'=>function($q){
                    $q->with([
                        'role',
                        'sectionYearDepartments' => function($q){
                            $q->with([
                                'department',
                                'sectionYear',
                            ]);
                        }
                    ]);
                }
             ])
              ->where('user_id', $request->id_number)
              ->first();
              return FetchingInfoResource::make($userInfo);

        }
        else{
            $userInfo = UserInfo::with([
                'user'=>function($q){
                    $q->with([
                        'role',
                        'sectionYearDepartments' => function($q){
                            $q->with([
                                'department',
                                'sectionYear',
                                'KlassDetails'=> fn($q) => $q->with(['subject','evaluatee'])
                            ]);
                        }
                    ]);
                }
             ])
              ->where('user_id',auth()->user()->id_number)
              ->first();
              return UserInfoResource::make($userInfo);
        }



            // return $userInfo;
    }


    public function updateUserInfo($request)
    {
        $user = UserInfo::firstOrCreate([
            'user_id' => auth()->user()->id_number
        ]);

        $user->first_name= $request['first_name'];
        $user->middle_name= $request['middle_name'];
        $user->last_name= $request['last_name'];
        $user->mobile_number= $request['mobile_number'];
        $user->course= $request['course'];
        $user->email= $request['email'];
        $user->save();
        return $user;

    }

    public function removeUserInfo($request)
    {
        $userInfo = UserInfo::findOrFail($request->id_number);
        $userInfo->delete();

        return "Successfully removed";

    }
}
