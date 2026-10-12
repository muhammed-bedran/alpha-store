<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrBonus;
use App\Models\HrEmployee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HrBonusesController extends Controller
{
    public function index(): View
    {
        $query = HrBonus::query()->with('employee');

        if ($name = request('name')) {
            $query->where(function ($q) use ($name) {
                $q->where('title', 'like', "%{$name}%")
                    ->orWhereHas('employee', fn ($employee) => $employee->where('name', 'like', "%{$name}%"));
            });
        }
        if ($type = request('type')) {
            $query->where('type', $type);
        }

        return view('dashboard.pages.hr.bonuses.index', [
            'bonuses' => $query->latest('date')->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.bonuses.create', [
            'bonus' => new HrBonus(['date' => now()->toDateString()]),
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        HrBonus::create($this->validated($request));

        return redirect()->route('dashboard.hr.bonuses.index')
            ->with('success', 'تم إضافة المكافأة بنجاح');
    }

    public function edit(HrBonus $bonus): View
    {
        return view('dashboard.pages.hr.bonuses.edit', [
            'bonus' => $bonus,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function update(Request $request, HrBonus $bonus): RedirectResponse
    {
        $bonus->update($this->validated($request));

        return redirect()->route('dashboard.hr.bonuses.index')
            ->with('success', 'تم تحديث المكافأة بنجاح');
    }

    public function destroy(HrBonus $bonus): RedirectResponse
    {
        $bonus->delete();

        return redirect()->route('dashboard.hr.bonuses.index')
            ->with('success', 'تم حذف المكافأة بنجاح');
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
            'type' => ['required', 'in:performance,overtime,holiday,commission,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
