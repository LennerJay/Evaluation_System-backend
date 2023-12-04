<?php
namespace App\Service\UserControllerService;

use App\Http\Resources\EvaluateeResource;
use App\Models\User;
use App\Models\Entity;
use App\Models\Evaluatee;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\SectionYearDepartment;

class UserService{


    public function fetchAllUsers()
    {
        $users = cache()->remember(
            'AllUsers',
            3600,
            function () {
            return  User::with(['role'])->get();
        });

      return  UserResource::collection($users);
    }


    public function saveManyStudentsBySection($request)
    {
        foreach($request['ids'] as $id){
            User::factory()->create(['id_number'=>$id , 'role_id'=>$request['role_id']]);
        }
        $syd = SectionYearDepartment::firstOrCreate([
            'section_year_id' => $request['s_y_id'],
            'department_id' =>$request['department_id']
        ]);

        $syd->users()->attach($request['ids']);

        $result = SectionYearDepartment::with([
            'department',
            'users',
            'sectionYear'
        ])->find($syd->id);

        return $result;
    }

    public function updateIdNumber($user,$request)
    {
        $user->id_number = $request['id_number'];
        $user->save();
        return $user;
    }

    public function resetPassword($user)
    {
        $user->password = Hash::make(123456);
        $user->save();
        return 'password reset successful';
    }


    public function changePassword($request)
    {
        $user = User::findOrFail($request['id_number']);
        if($user->id_number !== auth()->user()->id_number){
            return 'You are not the fcking owner of this account';
        }
        $user->password = Hash::make($request['password']);
        $user->save();
        return 'password change successful';
    }

    public function fetchEvaluateesToRate()
    {

        $instructor = Entity::where('entity_name','instructor')->first();
        $evaluatees = Evaluatee::with('entity')->where('entity_id','!=',$instructor->id)
                                ->get();

        $evaluateeDatas = EvaluateeResource::collection($evaluatees);
        $user = User::with([
                            'sectionYearDepartments' =>function($q){
                                $q->with([
                                    'evaluatees' =>function($q){
                                            $q->with('entity')->distinct();
                                        }
                                ]);
                            }
                    ])
                    ->find(auth()->user()->id_number);

        $userDatas =  EvaluateeResource::collection($user->sectionYearDepartments[0]->evaluatees);
        $response = [... $userDatas,...$evaluateeDatas];
        return $response;

    }

    public function fetchAllEvaluateesExceptInstructor()
    {
        $instructor = Entity::where('entity_name','instructor')->first();
        $evaluatees = Evaluatee::with('entity')->where('entity_id','!=',$instructor->id)->get();

        // return $evaluatees ;
        return EvaluateeResource::collection($evaluatees);
    }

}
