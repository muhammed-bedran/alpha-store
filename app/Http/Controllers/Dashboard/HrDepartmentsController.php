<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HrDepartmentsController extends Controller
{
    public function index(): View
    {
        $query = HrDepartment::query()->withCount('employees');

        if ($name = request('name')) {
            $query->where('name', 'like', "%{$name}%");
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        return view('dashboard.pages.hr.departments.index', [
            'departments' => $query->latest()->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.departments.create', [
            'department' => new HrDepartment,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        HrDepartment::create($this->validated($request));

        return redirect()->route('dashboard.hr.departments.index')
            ->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function edit(HrDepartment $department): View
    {
        return view('dashboard.pages.hr.departments.edit', compact('department'));
    }

    public function update(Request $request, HrDepartment $department): RedirectResponse
    {
        $department->update($this->validated($request));

        return redirect()->route('dashboard.hr.departments.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(HrDepartment $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('dashboard.hr.departments.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
