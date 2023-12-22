<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call([
            RatingGuardSeeder::class,
            RatingCanteenStaffSeeder::class,
            RatingInstructorSeeder::class
        ]);

    }

}
