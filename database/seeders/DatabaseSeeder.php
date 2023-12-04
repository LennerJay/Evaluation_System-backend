<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            RoleSeeder::class,
            SectionYearsSeeder::class,
            EntitySeeder::class,
            QuestionaireSeeder::class,
            DepartmentSeeder::class,
            SubjectSeeder::class,
            UserPerSectionSeeder::class,
            InstructorPerDepartmentSeeder::class

        ]);

    }
}
