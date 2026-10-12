<?php

namespace Database\Seeders;

use App\Models\HrBonus;
use App\Models\HrDeduction;
use App\Models\HrEmployee;
use App\Models\HrPayroll;
use Illuminate\Database\Seeder;

class HrCompensationSeeder extends Seeder
{
    public function run(): void
    {
        $sara = HrEmployee::query()->where('email', 'sara.hr@example.com')->first();
        $omar = HrEmployee::query()->where('email', 'omar.hr@example.com')->first();

        if ($sara) {
            HrBonus::query()->firstOrCreate(
                [
                    'employee_id' => $sara->id,
                    'title' => 'مكافأة إنجاز توظيف',
                ],
                [
                    'type' => 'performance',
                    'amount' => 250,
                    'date' => now()->toDateString(),
                    'notes' => 'إغلاق شاغر خلال أسبوع',
                ]
            );
        }

        if ($omar) {
            HrDeduction::query()->firstOrCreate(
                [
                    'employee_id' => $omar->id,
                    'title' => 'خصم تأخير',
                ],
                [
                    'type' => 'late',
                    'amount' => 40,
                    'date' => now()->toDateString(),
                ]
            );

            $totals = HrPayroll::totalsFor($omar, (int) now()->year, (int) now()->month);
            HrPayroll::query()->firstOrCreate(
                [
                    'employee_id' => $omar->id,
                    'year' => (int) now()->year,
                    'month' => (int) now()->month,
                ],
                [
                    'notes' => 'مسير تجريبي للشهر الحالي',
                    ...$totals,
                    'status' => 'draft',
                ]
            );
        }
    }
}
