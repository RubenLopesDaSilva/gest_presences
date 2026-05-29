<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level', // Ex: "Terminale", "Première", etc.
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(User::class)->where('role', 'student');
    }

    public function getPresentStudentsCountAttribute()
    {
        return $this->students()->get()->filter(function ($student) {
            return $student->status === 'PRESENT';
        })->count();
    }

    public function getAbsentStudentsCountAttribute()
    {
        return $this->students()->count() - $this->present_students_count;
    }
}
