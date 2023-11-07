<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\SectionYear;
use Illuminate\Database\Seeder;

class SubjectSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['math', 'science', 'english', 'history', 'social studies', 'art', 'music'] ;
        foreach ($subjects as $subject) {
            Subject::factory()->create(['name' => $subject]);
        }
        $sections_years =[
            '1-A','1-B','1-C','1-D','1-E','1-F',
            '2-A','2-B','2-C','2-D','2-E','2-F',
            '3-A','3-B','3-C','3-D','3-E','3-F',
            '4-A','4-B','4-C','4-D','4-E','4-F',
        ];
        foreach ($sections_years as $section_year) {
            SectionYear::factory()->create(['s_y' => $section_year]);
        }

    }
}
