<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrPayroll extends Model
{
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'base_salary',
        'bonuses_total',
        'deductions_total',
        'net_salary',
        'status',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'bonuses_total' => 'decimal:2',
            'deductions_total' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrEmployee::class, 'employee_id');
    }

    public function period(): string
    {
        return sprintf('%04d-%02d', $this->year, $this->month);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public static function totalsFor(HrEmployee $employee, int $year, int $month): array
    {
        $bonuses = (float) $employee->bonuses()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        $deductions = (float) $employee->deductions()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        $base = (float) ($employee->salary ?? 0);

        return [
            'base_salary' => $base,
            'bonuses_total' => $bonuses,
            'deductions_total' => $deductions,
            'net_salary' => $base + $bonuses - $deductions,
        ];
    }
}
