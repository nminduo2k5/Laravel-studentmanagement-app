<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    //
    
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $fillable = ['enroll_no', 'batch_id', 'student_id', 'join_date', 'fees'];
    use HasFactory;
    
    public function student()
    {
        return $this ->belongsto(Student::class);

    }
    public function batch()
    {
        return $this ->belongsto(Batch::class);

    }
}
