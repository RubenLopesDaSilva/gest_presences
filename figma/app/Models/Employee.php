<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'rfid',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function toggleStatus(): void
    {
        $this->status = $this->status === 'PRESENT' ? 'ABSENT' : 'PRESENT';
        $this->save();
    }

    public function isPresent(): bool
    {
        return $this->status === 'PRESENT';
    }
}
