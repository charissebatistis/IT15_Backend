<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $courses = Course::all();

        $firstNames = ['John', 'Mary', 'James', 'Patricia', 'Michael', 'Jennifer', 'William', 'Linda', 'David', 'Barbara',
                      'Richard', 'Susan', 'Joseph', 'Jessica', 'Thomas', 'Sarah', 'Charles', 'Karen', 'Christopher', 'Nancy'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
                     'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];

        $genders = ['Male', 'Female', 'Other'];

        // Create 500+ students
        for ($i = 1; $i <= 550; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $course = $courses->random();

            Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'student_id' => 'STU' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'course_id' => $course->id,
                'year_level' => $faker->numberBetween(1, 4),
                'email' => strtolower($firstName . '.' . $lastName . $i . '@student.edu'),
                'phone' => $faker->phoneNumber(),
                'date_of_birth' => $faker->dateTimeBetween('-25 years', '-18 years'),
                'gender' => $faker->randomElement($genders),
                'address' => $faker->address(),
                'enrollment_date' => $faker->dateTimeBetween('-4 years', 'now'),
            ]);

            // Update course enrollment count
            $course->increment('current_enrollment');
        }
    }
}
