<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\SectionYear;
use Illuminate\Database\Seeder;
use App\Models\SectionYearDepartment;
use App\Models\UserInfo;

class UserPerSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();
        $sys = SectionYear::all();
        $studentRole = Role::where('name','student')->first();
        foreach($departments as $department){
            foreach($sys as $sy){
             $syd =  SectionYearDepartment::create([
                'section_year_id' => $sy->id,
                'department_id' => $department->id
                ]);
                 User::factory(30)->create([
                    'role_id' => $studentRole->id
                ])->each(function ($user) use($syd){
                    UserInfo::factory()->create(['user_id' => $user->id_number]);
                    $user->sectionYearDepartments()->attach($syd->id);
                });
                // $userIds = $users->pluck('id_number');
                // $syd->users()->attach($userIds);

            }
        }

    }
}
