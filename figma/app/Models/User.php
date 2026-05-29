<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'student' ou 'teacher'
        'rfid_code',
        'classe_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function getStatusAttribute()
    {
        $lastLog = $this->attendanceLogs()
            ->whereDate('timestamp', today())
            ->latest('timestamp')
            ->first();

        if (!$lastLog) {
            return 'ABSENT';
        }

        return $lastLog->action === 'ENTREE' ? 'PRESENT' : 'ABSENT';
    }
}
