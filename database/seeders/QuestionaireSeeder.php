<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Criteria;
use App\Models\Question;
use App\Models\Questionaire;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
