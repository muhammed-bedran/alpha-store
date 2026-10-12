<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HrEmployee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'national_id',
        'department_id',
        'job_title',
        'hire_date',
        'salary',
        'status',
        'address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(HrDepartment::class, 'department_id');
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(HrLeaveRequest::class, 'employee_id');
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(HrBonus::class, 'employee_id');
    }

    public function deductions(): HasMany
    {
        return $this->hasMany(HrDeduction::class, 'employee_id');
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(HrPayroll::class, 'employee_id');
    }
}
