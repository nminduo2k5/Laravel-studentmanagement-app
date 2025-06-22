<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class CalculateStudentGPA extends Command
{
    protected $signature = 'student:calculate-gpa {student_id?}';
    protected $description = 'Recalculate GPA for a specific student or all students';

    public function handle()
    {
        $studentId = $this->argument('student_id');
        
        if ($studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $gpa = $student->calculateGPA();
                $this->info("GPA of student {$student->name}: {$gpa}");
            } else {
                $this->error("Student not found with ID: {$studentId}");
            }
        } else {
            $students = Student::all();
            $this->info("Recalculating GPA for {$students->count()} students...");
            
            foreach ($students as $student) {
                $gpa = $student->calculateGPA();
                $this->line("- {$student->name}: {$gpa}");
            }
            
            $this->info("Completed!");
        }
    }
}