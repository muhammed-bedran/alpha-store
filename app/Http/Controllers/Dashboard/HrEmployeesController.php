<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrDepartment;
use App\Models\HrEmployee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HrEmployeesController extends Controller
{
    public function index(): View
    {
        $query = HrEmployee::query()->with('department');

        if ($name = request('name')) {
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('email', 'like', "%{$name}%")
                    ->orWhere('job_title', 'like', "%{$name}%");
            });
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }
        if ($departmentId = request('department_id')) {
            $query->where('department_id', $departmentId);
        }

        return view('dashboard.pages.hr.employees.index', [
            'employees' => $query->latest()->paginate(),
            'departments' => HrDepartment::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.employees.create', [
            'employee' => new HrEmployee,
            'departments' => $this->departmentOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        HrEmployee::create($this->validated($request));

        return redirect()->route('dashboard.hr.employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }

    public function edit(HrEmployee $employee): View
    {
        return view('dashboard.pages.hr.employees.edit', [
            'employee' => $employee,
            'departments' => $this->departmentOptions(),
        ]);
    }

    public function update(Request $request, HrEmployee $employee): RedirectResponse
    {
        $employee->update($this->validated($request, $employee));

        return redirect()->route('dashboard.hr.employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    public function destroy(HrEmployee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('dashboard.hr.employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }

    protected function departmentOptions()
    {
        return HrDepartment::orderBy('name')->pluck('name', 'id');
    }

    protected function validated(Request $request, ?HrEmployee $employee = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('hr_employees', 'email')->ignore($employee?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:hr_departments,id'],
            'job_title' => ['nullable', 'string', 'max:100'],
            'hire_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,on_leave,inactive,terminated'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
