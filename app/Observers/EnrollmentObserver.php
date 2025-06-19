<?php

namespace App\Observers;

use App\Models\Enrollment;

class EnrollmentObserver
{
    public function updated(Enrollment $enrollment): void
    {
        // Tự động tính lại GPA khi điểm số thay đổi
        if ($enrollment->isDirty(['midterm_grade', 'final_grade', 'assignment_grade', 'total_grade'])) {
            $enrollment->student->calculateGPA();
        }
    }

    public function created(Enrollment $enrollment): void
    {
        // Tự động tính GPA khi tạo enrollment mới có điểm
        if ($enrollment->total_grade) {
            $enrollment->student->calculateGPA();
        }
    }

    public function deleted(Enrollment $enrollment): void
    {
        // Tính lại GPA khi xóa enrollment
        $enrollment->student->calculateGPA();
    }
}