<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Evaluatee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $deparments = ['BSIT','BEED','BSHRM'];
            foreach($deparments as $deparment){
                Department::create(['department'=> $deparment]);
            }

       $users = User::all();
       $evaluatees = Evaluatee::all();



       foreach($users as $user){
        $randomDepartment = Department::inRandomOrder()->first();
        $user->departments()->attach($randomDepartment->id);
       }
       foreach($evaluatees as $evaluatee){
            if($evaluatee->roles[0]->name === 'instructor'){
                $department = Department::inRandomOrder()->first();
                $evaluatee->departments()->attach($department->id);
            }

       }

    }
}
