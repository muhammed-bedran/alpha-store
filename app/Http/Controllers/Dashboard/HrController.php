<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HrBonus;
use App\Models\HrDeduction;
use App\Models\HrDepartment;
use App\Models\HrEmployee;
use App\Models\HrLeaveRequest;
use App\Models\HrPayroll;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HrController extends Controller
{
    public function index(): View
    {
        $stats = [
            'departments_count' => HrDepartment::count(),
            'employees_count' => HrEmployee::count(),
            'active_employees' => HrEmployee::where('status', 'active')->count(),
            'pending_leaves' => HrLeaveRequest::where('status', 'pending')->count(),
            'bonuses_month' => HrBonus::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount'),
            'deductions_month' => HrDeduction::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount'),
            'unpaid_payrolls' => HrPayroll::where('status', 'draft')->count(),
        ];

        $recentEmployees = HrEmployee::with('department')->latest()->take(5)->get();
        $pendingLeaves = HrLeaveRequest::with('employee')->where('status', 'pending')->latest()->take(5)->get();

        return view('dashboard.pages.hr.index', compact('stats', 'recentEmployees', 'pendingLeaves'));
    }

    public function about(): View
    {
        $path = base_path('docs/hr.md');
        $html = File::exists($path)
            ? Str::markdown(File::get($path))
            : '<p>ملف شرح الموارد البشرية غير موجود.</p>';

        return view('dashboard.pages.hr.about', compact('html'));
    }
}
