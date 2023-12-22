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
        $users =  User::with([
            'role',
            'sectionYearDepartments' => fn($q) => $q->with(['department','sectionYear'])
            ])
            ->withCount([
                'evaluatees as evaluatees_count' => function ($q) {
                    $q->where('evaluatees_users.is_done', true);
                }
            ])
            ->latest('updated_at')->get();
      return UserResource::collection($users);
    }

    public function saveManyStudentsBySection($request)
    {
        $defaultPassword = Hash::make(123456);
        foreach($request['ids'] as $id){
            $user = User::firstOrNew(['id_number' => $id]);
            if(!$user->exists){
                $user->id_number = $id;
                $user->password = $defaultPassword;
                $user->role_id = $request['role_id'];
                $user->save();
            }
        }
        $syd = SectionYearDepartment::firstOrCreate([
            'section_year_id' => $request['s_y_id'],
            'department_id' =>$request['department_id']
        ]);

        $syd->users()->syncWithoutDetaching($request['ids']);

        // $result = SectionYearDepartment::with([
        //     'department',
        //     'users',
        //     'sectionYear'
        // ])->find($syd->id);
            $users = [];
        foreach($request['ids'] as $id){
            $u =  User::with([
                'role',
                'sectionYearDepartments' => fn($q) => $q->with(['department','sectionYear'])
                ])
                ->withCount([
                    'evaluatees as evaluatees_count' => function ($q) {
                        $q->where('evaluatees_users.is_done', true);
                    }
                ])
                ->find( $id);

               array_push($users,UserResource::make($u));
        }

        return  $users;
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
