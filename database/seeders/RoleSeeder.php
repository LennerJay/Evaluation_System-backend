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

        $roleForStaff = Role::where('name','staff')->first();
        $roleForAdmin = Role::where('name','admin')->first();
        $roleForChairperson = Role::where('name','chairperson')->first();

        User::factory()->create(['id_number' => 11111,'role_id'=>$roleForAdmin->id]);
        User::factory()->create(['id_number' => 22222,'role_id'=>$roleForStaff->id]);
        UserInfo::factory()->create(['user_id' =>22222]);
        User::factory()->create(['id_number' => 33333,'role_id'=>$roleForChairperson->id]);
        UserInfo::factory()->create(['user_id' =>33333]);
        User::factory()->create(['id_number' => 44444,'role_id'=>$roleForChairperson->id]);
        UserInfo::factory()->create(['user_id' =>44444]);
        User::factory()->create(['id_number' => 55555,'role_id'=>$roleForChairperson->id]);
        UserInfo::factory()->create(['user_id' =>55555]);
    }
}
