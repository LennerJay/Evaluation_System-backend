<?php
namespace App\Service\UserControllerService;

use App\Http\Resources\SectionYearDepartmentResource;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\SectionYear;
use App\Models\SectionYearDepartment;
use Illuminate\Support\Facades\Hash;
use PDO;

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

}
