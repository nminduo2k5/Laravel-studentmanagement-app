<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    //
    
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'batch_id', 'student_id', 'join_date', 'fees'];
    use HasFactory;
}
