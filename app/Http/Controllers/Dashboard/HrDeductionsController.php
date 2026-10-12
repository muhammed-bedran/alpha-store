<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrDeduction;
use App\Models\HrEmployee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HrDeductionsController extends Controller
{
    public function index(): View
    {
        $query = HrDeduction::query()->with('employee');

        if ($name = request('name')) {
            $query->where(function ($q) use ($name) {
                $q->where('title', 'like', "%{$name}%")
                    ->orWhereHas('employee', fn ($employee) => $employee->where('name', 'like', "%{$name}%"));
            });
        }
        if ($type = request('type')) {
            $query->where('type', $type);
        }

        return view('dashboard.pages.hr.deductions.index', [
            'deductions' => $query->latest('date')->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.deductions.create', [
            'deduction' => new HrDeduction(['date' => now()->toDateString()]),
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        HrDeduction::create($this->validated($request));

        return redirect()->route('dashboard.hr.deductions.index')
            ->with('success', 'تم إضافة الخصم بنجاح');
    }

    public function edit(HrDeduction $deduction): View
    {
        return view('dashboard.pages.hr.deductions.edit', [
            'deduction' => $deduction,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function update(Request $request, HrDeduction $deduction): RedirectResponse
    {
        $deduction->update($this->validated($request));

        return redirect()->route('dashboard.hr.deductions.index')
            ->with('success', 'تم تحديث الخصم بنجاح');
    }

    public function destroy(HrDeduction $deduction): RedirectResponse
    {
        $deduction->delete();

        return redirect()->route('dashboard.hr.deductions.index')
            ->with('success', 'تم حذف الخصم بنجاح');
    }

    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:late,absence,loan,penalty,tax,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
