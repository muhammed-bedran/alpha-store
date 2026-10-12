<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrEmployee;
use App\Models\HrLeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HrLeaveRequestsController extends Controller
{
    public function index(): View
    {
        $query = HrLeaveRequest::query()->with('employee');

        if ($status = request('status')) {
            $query->where('status', $status);
        }
        if ($type = request('type')) {
            $query->where('type', $type);
        }
        if ($name = request('name')) {
            $query->whereHas('employee', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            });
        }

        return view('dashboard.pages.hr.leaves.index', [
            'leaves' => $query->latest()->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.hr.leaves.create', [
            'leave' => new HrLeaveRequest,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['days'] = HrLeaveRequest::calculateDays($data['start_date'], $data['end_date']);
        $data['status'] = 'pending';

        HrLeaveRequest::create($data);

        return redirect()->route('dashboard.hr.leaves.index')
            ->with('success', 'تم تسجيل طلب الإجازة بنجاح');
    }

    public function edit(HrLeaveRequest $leave): View
    {
        return view('dashboard.pages.hr.leaves.edit', [
            'leave' => $leave,
            'employees' => $this->employeeOptions(),
        ]);
    }

    public function update(Request $request, HrLeaveRequest $leave): RedirectResponse
    {
        $data = $this->validated($request);
        $data['days'] = HrLeaveRequest::calculateDays($data['start_date'], $data['end_date']);

        $leave->update($data);

        return redirect()->route('dashboard.hr.leaves.index')
            ->with('success', 'تم تحديث طلب الإجازة بنجاح');
    }

    public function destroy(HrLeaveRequest $leave): RedirectResponse
    {
        $leave->delete();

        return redirect()->route('dashboard.hr.leaves.index')
            ->with('success', 'تم حذف طلب الإجازة بنجاح');
    }

    public function approve(HrLeaveRequest $leave): RedirectResponse
    {
        $leave->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'review_notes' => request('review_notes'),
        ]);

        return redirect()->route('dashboard.hr.leaves.index')
            ->with('success', 'تم اعتماد طلب الإجازة');
    }

    public function reject(HrLeaveRequest $leave): RedirectResponse
    {
        $leave->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'review_notes' => request('review_notes'),
        ]);

        return redirect()->route('dashboard.hr.leaves.index')
            ->with('success', 'تم رفض طلب الإجازة');
    }

    protected function employeeOptions()
    {
        return HrEmployee::orderBy('name')->pluck('name', 'id');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'employee_id' => ['required', 'exists:hr_employees,id'],
            'type' => ['required', 'in:annual,sick,unpaid,emergency'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
        ]);
    }
}
