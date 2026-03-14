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

        // Specific names provided by user
        $specificStudents = [
            ['first_name' => 'Chelsea', 'last_name' => 'Fernandez'],
            ['first_name' => 'Nicole', 'last_name' => 'Borromeo'],
            ['first_name' => 'Ahtisa', 'last_name' => 'Manalo'],
            ['first_name' => 'Charisse', 'last_name' => 'Batistis'],
            ['first_name' => 'Juliana', 'last_name' => 'Gacayan'],
            ['first_name' => 'Mary Grace', 'last_name' => 'Bautista'],
            ['first_name' => 'Kim bee', 'last_name' => 'Morilla'],
            ['first_name' => 'Genevieve', 'last_name' => 'Herrera'],
        ];

        $firstNames = ['John', 'Mary', 'James', 'Patricia', 'Michael', 'Jennifer', 'William', 'Linda', 'David', 'Barbara',
                      'Richard', 'Susan', 'Joseph', 'Jessica', 'Thomas', 'Sarah', 'Charles', 'Karen', 'Christopher', 'Nancy',
                      'Mark', 'Lisa', 'Donald', 'Betty', 'Steven', 'Margaret', 'Paul', 'Sandra', 'Andrew', 'Ashley',
                      'Joshua', 'Kimberly', 'Kenneth', 'Donna', 'Kevin', 'Emily', 'Brian', 'Melissa', 'George', 'Deborah',
                      'Edward', 'Stephanie', 'Ronald', 'Rebecca', 'Anthony', 'Sharon', 'Frank', 'Laura', 'Ryan', 'Cynthia');
                      'Edward', 'Stephanie', 'Ronald', 'Rebecca', 'Anthony', 'Sharon', 'Frank', 'Laura', 'Ryan', 'Cynthia'];
        
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
                     'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
                     'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson',
                     'Walker', 'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Peterson', 'Phillips', 'Campbell',
                     'Parker', 'Evans', 'Edwards', 'Collins', 'Reeves', 'Stewart', 'Morris', 'Morales', 'Murphy', 'Cook'];

        $genders = ['Male', 'Female', 'Other'];

        // First, add the specific students provided
        foreach ($specificStudents as $index => $student) {
            $course = $courses->random();
            Student::create([
                'first_name' => $student['first_name'],
                'last_name' => $student['last_name'],
                'student_id' => 'STU' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'course_id' => $course->id,
                'year_level' => $faker->numberBetween(1, 4),
                'email' => strtolower(str_replace(' ', '.', $student['first_name']) . '.' . str_replace(' ', '.', $student['last_name']) . '@student.edu'),
                'phone' => $faker->phoneNumber(),
                'date_of_birth' => $faker->dateTimeBetween('-25 years', '-18 years'),
                'gender' => $faker->randomElement($genders),
                'address' => $faker->address(),
                'enrollment_date' => $faker->dateTimeBetween('-4 years', 'now'),
            ]);
            $course->increment('current_enrollment');
        }

        // Create remaining students with random names (550 total - 8 specific = 542 remaining)
        for ($i = 9; $i <= 550; $i++) {
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
