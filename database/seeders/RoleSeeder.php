<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['student','admin','staff','chairperson'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $users = User::all();

        $roleForStudent = Role::where('name','student')->first();
        $roleForStaff = Role::where('name','staff')->first();
        $roleForAdmin = Role::where('name','admin')->first();
        $roleForChairperson = Role::where('name','chairperson')->first();

        foreach ($users as $user) {
            $user->roles()->attach($roleForStudent->id);
        }




        $admin = User::factory()->create(['id_number' => 11111]);
        $admin ->roles()->attach($roleForAdmin->id);
        $staff = User::factory()->create(['id_number' => 22222]);
        UserInfo::factory()->create(['user_id' =>22222]);
        $staff->roles()->attach($roleForStaff->id);
        $chairperson = User::factory()->create(['id_number' => 33333]);
        UserInfo::factory()->create(['user_id' =>33333]);
        $chairperson->roles()->attach($roleForChairperson->id);
    }
}
