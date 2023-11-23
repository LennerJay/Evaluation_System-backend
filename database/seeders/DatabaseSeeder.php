<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Criteria;
use App\Models\Department;
use App\Models\Entity;
use App\Models\Question;
use App\Models\UserInfo;
use App\Models\Evaluatee;
use App\Models\Questionaire;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ////<----this function is for no ratings
        $this->call([SubjectSectionSeeder::class,TestSeeder::class,DepartmentSeeder::class,RoleSeeder::class]);
        ////-------->

        $entities = Entity::all();

        foreach ($entities as $entity) {
            $questionaires = Questionaire::factory(2)->create(['description' => 'This questionaire is for ' . $entity->entity_name]);
            foreach($questionaires as $questionaire) {
                $entity->questionaires()->attach($questionaire->id);
            }
        }



        $questionaires = Questionaire::all();

        foreach($questionaires as $questionaire){

            $criterias = Criteria::factory(5)->create()->each(function($criteria)use ($questionaire){
                $questionaire->criterias()->attach($criteria->id);
            });
            foreach($criterias as $criteria){
                Question::factory(5)->create(['criteria_id' => $criteria->id]);
            }
        }
    }
}
