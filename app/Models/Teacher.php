<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Teacher extends Model
{
    
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];
    use HasFactory;
}
