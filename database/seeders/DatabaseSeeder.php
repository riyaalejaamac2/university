<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Semesters
        $semesters = [];
        $academicYear = date('Y') . '-' . (date('Y') + 1);

        for ($i = 1; $i <= 8; $i++) {
            $semesters[$i] = Semester::create([
                'name' => "Semester $i",
                'group' => 'None',
                'academic_year' => $academicYear,
                'status' => 'Active',
            ]);
        }

        // 2. Create Students linked to Semesters
        $studentsData = [
            // Semester 1
            ['student_id' => 'S001', 'fullname' => 'Ahmed Mohamed Ali', 'gender' => 'Male', 'semester' => 1, 'department' => 'Computer Science'],
            ['student_id' => 'S002', 'fullname' => 'Fatima Hassan Ahmed', 'gender' => 'Female', 'semester' => 1, 'department' => 'Computer Science'],
            ['student_id' => 'S003', 'fullname' => 'Omar Abdi Hussein', 'gender' => 'Male', 'semester' => 1, 'department' => 'Engineering'],
            ['student_id' => 'S004', 'fullname' => 'Amina Said Osman', 'gender' => 'Female', 'semester' => 1, 'department' => 'Engineering'],
            ['student_id' => 'S005', 'fullname' => 'Hassan Ibrahim Mohamed', 'gender' => 'Male', 'semester' => 1, 'department' => 'Medicine'],

            // Semester 2
            ['student_id' => 'S006', 'fullname' => 'Khadija Ali Hassan', 'gender' => 'Female', 'semester' => 2, 'department' => 'Computer Science'],
            ['student_id' => 'S007', 'fullname' => 'Yusuf Mohamed Ahmed', 'gender' => 'Male', 'semester' => 2, 'department' => 'Computer Science'],
            ['student_id' => 'S008', 'fullname' => 'Aisha Abdi Ali', 'gender' => 'Female', 'semester' => 2, 'department' => 'Engineering'],
            ['student_id' => 'S009', 'fullname' => 'Ibrahim Hassan Omar', 'gender' => 'Male', 'semester' => 2, 'department' => 'Medicine'],
            ['student_id' => 'S010', 'fullname' => 'Mariam Said Mohamed', 'gender' => 'Female', 'semester' => 2, 'department' => 'Business'],

            // Semester 3
            ['student_id' => 'S011', 'fullname' => 'Abdullahi Mohamed Hassan', 'gender' => 'Male', 'semester' => 3, 'department' => 'Computer Science'],
            ['student_id' => 'S012', 'fullname' => 'Halima Ali Ahmed', 'gender' => 'Female', 'semester' => 3, 'department' => 'Engineering'],
            ['student_id' => 'S013', 'fullname' => 'Mohamed Ibrahim Ali', 'gender' => 'Male', 'semester' => 3, 'department' => 'Medicine'],
            ['student_id' => 'S014', 'fullname' => 'Sahra Hassan Said', 'gender' => 'Female', 'semester' => 3, 'department' => 'Business'],
            ['student_id' => 'S015', 'fullname' => 'Abdi Osman Mohamed', 'gender' => 'Male', 'semester' => 3, 'department' => 'Computer Science'],
        ];

        foreach ($studentsData as $data) {
            $semNum = $data['semester'];
            $data['semester_id'] = $semesters[$semNum]->id; // Link to Created Semester
            Student::create($data);
        }

        // 3. Create Courses linked to Semesters
        $coursesData = [
            // Semester 1
            ['course_name' => 'Introduction to Programming', 'teacher_name' => 'Dr. Ahmed Farah', 'semester' => 1, 'description' => 'Basic programming concepts using Python'],
            ['course_name' => 'Mathematics I', 'teacher_name' => 'Prof. Hassan Ali', 'semester' => 1, 'description' => 'Calculus and algebra fundamentals'],
            ['course_name' => 'Physics I', 'teacher_name' => 'Dr. Fatima Omar', 'semester' => 1, 'description' => 'Mechanics and thermodynamics'],

            // Semester 2
            ['course_name' => 'Data Structures', 'teacher_name' => 'Dr. Mohamed Hassan', 'semester' => 2, 'description' => 'Arrays, linked lists, trees, and graphs'],
            ['course_name' => 'Database Systems', 'teacher_name' => 'Prof. Amina Said', 'semester' => 2, 'description' => 'Relational databases and SQL'],
            ['course_name' => 'Mathematics II', 'teacher_name' => 'Dr. Ibrahim Ahmed', 'semester' => 2, 'description' => 'Linear algebra and differential equations'],

            // Semester 3
            ['course_name' => 'Web Development', 'teacher_name' => 'Dr. Khadija Ali', 'semester' => 3, 'description' => 'HTML, CSS, JavaScript, and PHP'],
            ['course_name' => 'Software Engineering', 'teacher_name' => 'Prof. Yusuf Mohamed', 'semester' => 3, 'description' => 'Software development methodologies'],
            ['course_name' => 'Computer Networks', 'teacher_name' => 'Dr. Aisha Hassan', 'semester' => 3, 'description' => 'Network protocols and architecture'],
        ];

        foreach ($coursesData as $data) {
            $semNum = $data['semester'];
            $data['semester_id'] = $semesters[$semNum]->id; // Link to Created Semester
            Course::create($data);
        }

        // 4. Create Sample Attendance Records
        $allStudents = Student::all();
        $allCourses = Course::all();

        foreach ($allCourses as $course) {
            // Get students in the same semester as the course
            // Use semester_id match
            $semesterStudents = $allStudents->where('semester_id', $course->semester_id);

            // Create attendance for the last 5 days
            for ($i = 0; $i < 5; $i++) {
                $date = now()->subDays($i)->format('Y-m-d');

                foreach ($semesterStudents as $student) {
                    $status = rand(1, 100) <= 80 ? 'Present' : 'Absent';

                    Attendance::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'semester' => $course->semester, // Keep legacy for safety
                        'semester_id' => $course->semester_id, // New
                        'academic_year' => $academicYear,
                        'date' => $date,
                        'status' => $status,
                    ]);
                }
            }
        }
    }
}
