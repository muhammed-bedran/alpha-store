<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\HrDepartment;
use App\Models\HrEmployee;
use App\Models\HrLeaveRequest;
use App\Models\HrPayroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HrModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): Admin
    {
        return Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'super_admin' => true,
            'status' => 'active',
        ]);
    }

    public function test_guests_cannot_access_hr(): void
    {
        $this->get(route('dashboard.hr.index'))->assertRedirect();
    }

    public function test_admin_can_view_hr_dashboard_and_about_page(): void
    {
        $this->actingAs($this->admin(), 'admin');

        $this->get(route('dashboard.hr.index'))
            ->assertOk()
            ->assertSee('الموارد البشرية');

        $this->get(route('dashboard.hr.about'))
            ->assertOk()
            ->assertSee('Human Resources');
    }

    public function test_admin_can_manage_departments_employees_and_leaves(): void
    {
        $this->actingAs($this->admin(), 'admin');

        $this->post(route('dashboard.hr.departments.store'), [
            'name' => 'التوظيف',
            'description' => 'استقطاب الموظفين',
            'status' => 'active',
        ])->assertRedirect(route('dashboard.hr.departments.index'));

        $department = HrDepartment::query()->first();
        $this->assertNotNull($department);

        $this->post(route('dashboard.hr.employees.store'), [
            'name' => 'أحمد علي',
            'email' => 'ahmad@example.com',
            'department_id' => $department->id,
            'job_title' => 'موظف موارد بشرية',
            'hire_date' => '2026-01-01',
            'salary' => 2000,
            'status' => 'active',
        ])->assertRedirect(route('dashboard.hr.employees.index'));

        $employee = HrEmployee::query()->first();
        $this->assertSame('أحمد علي', $employee->name);

        $this->post(route('dashboard.hr.leaves.store'), [
            'employee_id' => $employee->id,
            'type' => 'annual',
            'start_date' => '2026-09-10',
            'end_date' => '2026-09-12',
            'reason' => 'إجازة قصيرة',
        ])->assertRedirect(route('dashboard.hr.leaves.index'));

        $leave = HrLeaveRequest::query()->first();
        $this->assertSame(3, $leave->days);
        $this->assertSame('pending', $leave->status);

        $this->post(route('dashboard.hr.leaves.approve', $leave))
            ->assertRedirect(route('dashboard.hr.leaves.index'));

        $this->assertSame('approved', $leave->fresh()->status);
    }

    public function test_admin_can_manage_bonuses_deductions_and_payroll(): void
    {
        $this->actingAs($this->admin(), 'admin');

        $employee = HrEmployee::create([
            'name' => 'ليان حسن',
            'email' => 'layan@example.com',
            'job_title' => 'محاسبة',
            'salary' => 2000,
            'status' => 'active',
        ]);

        $this->post(route('dashboard.hr.bonuses.store'), [
            'employee_id' => $employee->id,
            'title' => 'مكافأة أداء',
            'type' => 'performance',
            'amount' => 300,
            'date' => '2026-09-05',
        ])->assertRedirect(route('dashboard.hr.bonuses.index'));

        $this->post(route('dashboard.hr.deductions.store'), [
            'employee_id' => $employee->id,
            'title' => 'خصم تأخير',
            'type' => 'late',
            'amount' => 50,
            'date' => '2026-09-08',
        ])->assertRedirect(route('dashboard.hr.deductions.index'));

        $this->post(route('dashboard.hr.payrolls.store'), [
            'employee_id' => $employee->id,
            'period' => '2026-09',
        ])->assertRedirect(route('dashboard.hr.payrolls.index'));

        $payroll = HrPayroll::query()->first();
        $this->assertEquals(2000, (float) $payroll->base_salary);
        $this->assertEquals(300, (float) $payroll->bonuses_total);
        $this->assertEquals(50, (float) $payroll->deductions_total);
        $this->assertEquals(2250, (float) $payroll->net_salary);
        $this->assertSame('draft', $payroll->status);

        $this->post(route('dashboard.hr.payrolls.pay', $payroll))
            ->assertRedirect(route('dashboard.hr.payrolls.index'));

        $this->assertSame('paid', $payroll->fresh()->status);
    }
}
