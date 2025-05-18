<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model
{
    
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'syllabus', 'duration'];
    use HasFactory;
}
