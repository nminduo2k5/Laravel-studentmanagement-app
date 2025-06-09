<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'gpa', 'address', 'mobile'];
    
    /**
     * Get the enrollments for the student.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    
    /**
     * Get all payments made by this student through enrollments.
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }
}
