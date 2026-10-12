<?php

namespace Database\Seeders;

use App\Models\HrDepartment;
use App\Models\HrEmployee;
use App\Models\HrLeaveRequest;
use Illuminate\Database\Seeder;

class HrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recruitment = HrDepartment::create([
            'name' => 'التوظيف واستقطاب المواهب',
            'description' => 'استقطاب المرشحين، المقابلات، وتعيين الموظفين الجدد.',
            'status' => 'active',
        ]);
        $operations = HrDepartment::create([
            'name' => 'العمليات والرواتب',
            'description' => 'ملفات الموظفين، الرواتب، الإجازات، والحضور.',
            'status' => 'active',
        ]);
        $development = HrDepartment::create([
            'name' => 'التدريب والتطوير',
            'description' => 'برامج التدريب وتقييم الأداء وتطوير المهارات.',
            'status' => 'active',
        ]);
        HrDepartment::create([
            'name' => 'علاقات الموظفين والامتثال',
            'description' => 'شكاوى الموظفين، بيئة العمل، والالتزام بقانون العمل.',
            'status' => 'active',
        ]);

        $sara = HrEmployee::create([
            'name' => 'سارة أحمد',
            'email' => 'sara.hr@example.com',
            'phone' => '0599000001',
            'national_id' => '401234567',
            'department_id' => $recruitment->id,
            'job_title' => 'مسؤولة توظيف',
            'hire_date' => now()->subYears(2)->toDateString(),
            'salary' => 3200,
            'status' => 'active',
            'address' => 'رام الله',
        ]);

        $omar = HrEmployee::create([
            'name' => 'عمر خالد',
            'email' => 'omar.hr@example.com',
            'phone' => '0599000002',
            'department_id' => $operations->id,
            'job_title' => 'أخصائي رواتب',
            'hire_date' => now()->subYear()->toDateString(),
            'salary' => 2800,
            'status' => 'active',
            'address' => 'نابلس',
        ]);

        HrEmployee::create([
            'name' => 'ليلى منصور',
            'email' => 'laila.hr@example.com',
            'phone' => '0599000003',
            'department_id' => $development->id,
            'job_title' => 'منسقة تدريب',
            'hire_date' => now()->subMonths(8)->toDateString(),
            'salary' => 2500,
            'status' => 'on_leave',
            'address' => 'الخليل',
        ]);

        HrLeaveRequest::create([
            'employee_id' => $sara->id,
            'type' => 'annual',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'days' => 5,
            'reason' => 'إجازة سنوية عائلية',
            'status' => 'pending',
        ]);

        HrLeaveRequest::create([
            'employee_id' => $omar->id,
            'type' => 'sick',
            'start_date' => now()->subDays(3)->toDateString(),
            'end_date' => now()->subDay()->toDateString(),
            'days' => 3,
            'reason' => 'إجازة مرضية مع تقرير طبي',
            'status' => 'approved',
            'reviewed_at' => now()->subDays(3),
        ]);

        $this->call(HrCompensationSeeder::class);
    }
}
