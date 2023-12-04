<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\SectionYear;
use Illuminate\Database\Seeder;
use App\Models\sectionYearDepartment;
use App\Models\UserInfo;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $deparmentDatas = ['bsit','bshrm','beed','bsed'];
            foreach($deparmentDatas as $deparmentData){
                Department::create(['name'=> $deparmentData]);
            }

        // $roleForStudent = Role::where('name','student')->first();
        // $deparments = Department::all();
        // $sys = SectionYear::all();

        // foreach($deparments as $deparment){
        //     foreach($sys as $sy){
        //         $sydId = sectionYearDepartment::create([
        //             'department_id'=>$deparment->id,
        //             'section_year_id'=>$sy->id
        //         ]);
        //         User::factory(30)->create(['role_id'=>$roleForStudent])->each(function($user)use($sydId){
        //             UserInfo::factory()->create(['user_id'=>$user->id_number]);
        //             $user->sectionYearDepartment()->attach($sydId);
        //         });
        //     }
        // }















    //    $users = User::all();
    //    $evaluatees = Evaluatee::where('entity_id',1)->get();

    //    foreach($users as $user){
    //     $randomDepartment = Department::inRandomOrder()->first();
    //     $user->departments()->attach($randomDepartment->id);
    //    }

    //    foreach($evaluatees  as $evaluatee){
    //             $department = Department::all();
    //             $randomDepartment = $department->random();
    //             $evaluatee->departments()->attach($randomDepartment->id);
    //    }

    }
}
