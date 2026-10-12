<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrEmployee;
use App\Models\HrPayroll;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HrPayrollsController extends Controller
{
    public function index(): View
    {
        $query = HrPayroll::query()->with('employee');

        if ($name = request('name')) {
            $query->whereHas('employee', fn ($q) => $q->where('name', 'like', "%{$name}%"));
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }
        if ($period = request('period')) {
            [$year, $month] = $this->splitPeriod($period);
            if ($year && $month) {
                $query->where('year', $year)->where('month', $month);
            }
        }

        return view('dashboard.pages.hr.payrolls.index', [
            'payrolls' => $query->orderByDesc('year')->orderByDesc('month')->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.payrolls.create', [
            'payroll' => new HrPayroll,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        [$year, $month] = $this->splitPeriod($data['period']);
        $employee = HrEmployee::findOrFail($data['employee_id']);
        $totals = HrPayroll::totalsFor($employee, $year, $month);

        HrPayroll::create([
            'employee_id' => $employee->id,
            'year' => $year,
            'month' => $month,
            'notes' => $data['notes'] ?? null,
            ...$totals,
            'status' => 'draft',
        ]);

        return redirect()->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم إنشاء مسير الراتب بنجاح');
    }

    public function show(HrPayroll $payroll): View
    {
        $payroll->load('employee');
        $bonuses = $payroll->employee->bonuses()
            ->whereYear('date', $payroll->year)
            ->whereMonth('date', $payroll->month)
            ->get();
        $deductions = $payroll->employee->deductions()
            ->whereYear('date', $payroll->year)
            ->whereMonth('date', $payroll->month)
            ->get();

        return view('dashboard.pages.hr.payrolls.show', compact('payroll', 'bonuses', 'deductions'));
    }

    public function edit(HrPayroll $payroll): View|RedirectResponse
    {
        if ($payroll->isPaid()) {
            return redirect()->route('dashboard.hr.payrolls.show', $payroll)
                ->with('error', 'لا يمكن تعديل راتب مدفوع');
        }

        return view('dashboard.pages.hr.payrolls.edit', [
            'payroll' => $payroll,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function update(Request $request, HrPayroll $payroll): RedirectResponse
    {
        if ($payroll->isPaid()) {
            return redirect()->route('dashboard.hr.payrolls.index')
                ->with('error', 'لا يمكن تعديل راتب مدفوع');
        }

        $data = $this->validated($request, $payroll);
        [$year, $month] = $this->splitPeriod($data['period']);
        $employee = HrEmployee::findOrFail($data['employee_id']);
        $totals = HrPayroll::totalsFor($employee, $year, $month);

        $payroll->update([
            'employee_id' => $employee->id,
            'year' => $year,
            'month' => $month,
            'notes' => $data['notes'] ?? null,
            ...$totals,
        ]);

        return redirect()->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم إعادة احتساب مسير الراتب بنجاح');
    }

    public function destroy(HrPayroll $payroll): RedirectResponse
    {
        $payroll->delete();

        return redirect()->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم حذف مسير الراتب بنجاح');
    }

    public function pay(HrPayroll $payroll): RedirectResponse
    {
        if ($payroll->isPaid()) {
            return redirect()->route('dashboard.hr.payrolls.index')
                ->with('error', 'هذا الراتب مدفوع مسبقاً');
        }

        $payroll->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('dashboard.hr.payrolls.index')
            ->with('success', 'تم تعليم الراتب كمدفوع');
    }

    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    protected function splitPeriod(?string $period): array
    {
        if (! $period || ! preg_match('/^\d{4}-\d{2}$/', $period)) {
            return [null, null];
        }

        [$year, $month] = explode('-', $period);

        return [(int) $year, (int) $month];
    }

    protected function validated(Request $request, ?HrPayroll $payroll = null): array
    {
        $period = (string) $request->input('period');
        [$year, $month] = $this->splitPeriod($period);

        return $request->validate([
            'employee_id' => [
                'required',
                'exists:hr_employees,id',
                Rule::unique('hr_payrolls', 'employee_id')
                    ->ignore($payroll?->id)
                    ->where(fn ($query) => $query->where('year', $year)->where('month', $month)),
            ],
            'period' => ['required', 'date_format:Y-m'],
            'notes' => ['nullable', 'string'],
        ], [
            'employee_id.unique' => 'يوجد مسير راتب لهذا الموظف في نفس الشهر',
        ]);
    }
}
