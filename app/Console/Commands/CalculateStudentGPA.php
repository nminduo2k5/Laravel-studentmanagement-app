<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class CalculateStudentGPA extends Command
{
    protected $signature = 'student:calculate-gpa {student_id?}';
    protected $description = 'Tính lại GPA cho sinh viên từ điểm enrollment';

    public function handle()
    {
        $studentId = $this->argument('student_id');
        
        if ($studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $gpa = $student->calculateGPA();
                $this->info("GPA của sinh viên {$student->name}: {$gpa}");
            } else {
                $this->error("Không tìm thấy sinh viên với ID: {$studentId}");
            }
        } else {
            $students = Student::all();
            $this->info("Đang tính lại GPA cho {$students->count()} sinh viên...");
            
            foreach ($students as $student) {
                $gpa = $student->calculateGPA();
                $this->line("- {$student->name}: {$gpa}");
            }
            
            $this->info("Hoàn thành!");
        }
    }
}