<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Computer Science', 'Information Technology', 'Business', 'Engineering', 'Liberal Arts'];
        $instructors = ['Dr. Johnson', 'Prof. Smith', 'Dr. Williams', 'Prof. Brown', 'Dr. Davis', 'Prof. Miller', 'Dr. Wilson', 'Prof. Moore'];

        $courses = [
            // Computer Science
            ['CS101', 'Introduction to Programming', 'Computer Science', 'Learn the basics of programming', 3, 'Dr. Johnson', 50, 0],
            ['CS201', 'Data Structures', 'Computer Science', 'Advanced data structures and algorithms', 4, 'Prof. Smith', 40, 0],
            ['CS301', 'Web Development', 'Computer Science', 'Building web applications', 3, 'Dr. Williams', 45, 0],
            ['CS401', 'Database Systems', 'Computer Science', 'SQL and database design', 4, 'Prof. Brown', 35, 0],
            ['CS501', 'Machine Learning', 'Computer Science', 'AI and machine learning fundamentals', 4, 'Dr. Davis', 30, 0],
            
            // Information Technology
            ['IT101', 'IT Fundamentals', 'Information Technology', 'Basic IT concepts', 3, 'Prof. Miller', 50, 0],
            ['IT201', 'Network Administration', 'Information Technology', 'Managing networks', 4, 'Dr. Wilson', 40, 0],
            ['IT301', 'Cybersecurity Basics', 'Information Technology', 'Security fundamentals', 3, 'Prof. Moore', 35, 0],
            ['IT401', 'Cloud Computing', 'Information Technology', 'Cloud platforms and services', 4, 'Dr. Johnson', 40, 0],
            ['IT501', 'System Administration', 'Information Technology', 'Server and system management', 4, 'Prof. Smith', 30, 0],
            
            // Business
            ['BUS101', 'Business Fundamentals', 'Business', 'Introduction to business', 3, 'Dr. Williams', 60, 0],
            ['BUS201', 'Accounting', 'Business', 'Financial accounting principles', 4, 'Prof. Brown', 50, 0],
            ['BUS301', 'Marketing Strategy', 'Business', 'Strategic marketing concepts', 3, 'Dr. Davis', 45, 0],
            ['BUS401', 'Management', 'Business', 'Organizational management', 3, 'Prof. Miller', 50, 0],
            ['BUS501', 'Finance', 'Business', 'Corporate finance', 4, 'Dr. Wilson', 40, 0],
            
            // Engineering
            ['ENG101', 'Engineering Fundamentals', 'Engineering', 'Basic engineering concepts', 4, 'Prof. Moore', 45, 0],
            ['ENG201', 'Mechanical Engineering', 'Engineering', 'Mechanics and machines', 4, 'Dr. Johnson', 40, 0],
            ['ENG301', 'Electrical Engineering', 'Engineering', 'Electrical systems', 4, 'Prof. Smith', 35, 0],
            ['ENG401', 'Civil Engineering', 'Engineering', 'Construction and structures', 4, 'Dr. Williams', 40, 0],
            ['ENG501', 'Software Engineering', 'Engineering', 'Software development methodology', 4, 'Prof. Brown', 35, 0],
        ];

        foreach ($courses as $course) {
            Course::create([
                'course_code' => $course[0],
                'course_name' => $course[1],
                'department' => $course[2],
                'description' => $course[3],
                'credits' => $course[4],
                'instructor_name' => $course[5],
                'max_capacity' => $course[6],
                'current_enrollment' => $course[7],
            ]);
        }
    }
}
