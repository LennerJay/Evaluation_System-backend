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

        $deparments = ['bsit','bshrm','beed','bsed'];
            foreach($deparments as $deparment){
                Department::create(['department'=> $deparment]);
            }

       $users = User::all();
       $evaluatees = Evaluatee::where('entity_id',1)->get();

       foreach($users as $user){
        $randomDepartment = Department::inRandomOrder()->first();
        $user->departments()->attach($randomDepartment->id);
       }

       foreach($evaluatees  as $evaluatee){
                $department = Department::all();
                $randomDepartment = $department->random();
                $evaluatee->departments()->attach($randomDepartment->id);
       }

    }
}
