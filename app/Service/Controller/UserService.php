<?php
namespace App\Service\Controller;

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
            return  User::with([
                'role',
                'sectionYearDepartments' => fn($q) => $q->with(['department','sectionYear'])
                ])
                ->latest()->get();
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
            return 'You are not the owner of this account';
        }
        $user->password = Hash::make($request['password']);
        $user->save();
        return 'password change successful';
    }

    public function fetchEvaluateesToRate()
    {
        $user = User::with([
                             'evaluatees' => function ($query) {
                                $query->with([
                                            'entity',
                                            'SectionYearDepartments' =>function($q){
                                            $q->with([
                                                'department',
                                            ]);
                                        }
                                    ])
                                    ->withCount([
                                            'users' => function ( $query) {
                                            $query->where('evaluatees_users.is_done', 1);
                                        }
                                    ]);
                                }
                         ])
                        // ->withCasts(['updated_at'=> 'datetime'])
                         ->find(auth()->user()->id_number);

        if(count($user->evaluatees) == 0){
            $instructor = Entity::where('entity_name','instructor')->first();
            $evaluatees = Evaluatee::with('entity')->where('entity_id','!=',$instructor->id)
                                    ->get();
            $evaluateeDatas = EvaluateeResource::collection($evaluatees);
            $userInfo = User::with([
                                'sectionYearDepartments' =>function($q){
                                    $q->with([
                                        'evaluatees' =>function($q){
                                                $q->with('entity')->distinct();
                                            }
                                    ]);
                                },
                                // 'evaluatees'
                        ])
                        ->find(auth()->user()->id_number);

            $userDatas =  EvaluateeResource::collection($userInfo->sectionYearDepartments[0]->evaluatees);
            $result = [... $userDatas,...$evaluateeDatas];
            $ids = collect($result)->pluck('id');
            $userInfo->evaluatees()->attach($ids);
            $userWithEvaluatees = User::with([
                                                'evaluatees' =>function($q){
                                                        $q->with([
                                                                'entity',
                                                                'SectionYearDepartments' =>function($q){
                                                                    $q->with([
                                                                        'department',
                                                                    ]);
                                                                }
                                                            ])
                                                            ->withCount([
                                                            'users' => function ( $query) {
                                                                $query->where('evaluatees_users.is_done', 1);
                                                            }
                                                        ]);
                                                    }
                                            ])
                                            ->find(auth()->user()->id_number);
            return EvaluateeResource::collection($userWithEvaluatees->evaluatees);

        }


        return EvaluateeResource::collection($user->evaluatees);

    }


}
