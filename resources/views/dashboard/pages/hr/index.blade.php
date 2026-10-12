@extends('layouts.dashboard')

@section('title', 'الموارد البشرية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'index'])

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['departments_count'] }}</h3>
                    <p>الأقسام</p>
                </div>
                <div class="icon"><i class="fas fa-sitemap"></i></div>
                <a href="{{ route('dashboard.hr.departments.index') }}" class="small-box-footer">إدارة الأقسام <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['employees_count'] }}</h3>
                    <p>الموظفون</p>
                </div>
                <div class="icon"><i class="fas fa-user-tie"></i></div>
                <a href="{{ route('dashboard.hr.employees.index') }}" class="small-box-footer">إدارة الموظفين <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['active_employees'] }}</h3>
                    <p>موظفون نشطون</p>
                </div>
                <div class="icon"><i class="fas fa-user-check"></i></div>
                <a href="{{ route('dashboard.hr.employees.index', ['status' => 'active']) }}" class="small-box-footer">عرض النشطين <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['pending_leaves'] }}</h3>
                    <p>إجازات بانتظار الاعتماد</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <a href="{{ route('dashboard.hr.leaves.index', ['status' => 'pending']) }}" class="small-box-footer">مراجعة الطلبات <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format((float) $stats['bonuses_month'], 0) }}</h3>
                    <p>مكافآت هذا الشهر</p>
                </div>
                <div class="icon"><i class="fas fa-gift"></i></div>
                <a href="{{ route('dashboard.hr.bonuses.index') }}" class="small-box-footer">إدارة المكافآت <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format((float) $stats['deductions_month'], 0) }}</h3>
                    <p>خصومات هذا الشهر</p>
                </div>
                <div class="icon"><i class="fas fa-minus-circle"></i></div>
                <a href="{{ route('dashboard.hr.deductions.index') }}" class="small-box-footer">إدارة الخصومات <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['unpaid_payrolls'] }}</h3>
                    <p>رواتب غير مدفوعة</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                <a href="{{ route('dashboard.hr.payrolls.index', ['status' => 'draft']) }}" class="small-box-footer">مسيرات الرواتب <i class="fas fa-arrow-circle-left"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">الأقسام</h3></div>
                <div class="card-body">
                    هيكل الشركة الداخلي: توظيف، رواتب، تدريب، وعلاقات موظفين.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.departments.create') }}" class="btn btn-primary btn-sm">إضافة قسم</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">الموظفون</h3></div>
                <div class="card-body">
                    ملفات الموظفين: الوظيفة، القسم، الراتب، وتاريخ التعيين.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.employees.create') }}" class="btn btn-success btn-sm">إضافة موظف</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-warning">
                <div class="card-header"><h3 class="card-title">الإجازات وشرح HR</h3></div>
                <div class="card-body">
                    اعتماد الإجازات، وقراءة شرح كامل عن الموارد البشرية وأقسامها.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.leaves.create') }}" class="btn btn-warning btn-sm">طلب إجازة</a>
                        <a href="{{ route('dashboard.hr.about') }}" class="btn btn-secondary btn-sm">ماذا هو الـ HR؟</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">المكافآت</h3></div>
                <div class="card-body">
                    مكافأة أداء، عمل إضافي، عمولة، أو مناسبة. تدخل في راتب الشهر.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.bonuses.create') }}" class="btn btn-success btn-sm">إضافة مكافأة</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header"><h3 class="card-title">الخصومات</h3></div>
                <div class="card-body">
                    تأخير، غياب، سلفة، أو جزاء. تُطرح من راتب الشهر.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.deductions.create') }}" class="btn btn-danger btn-sm">إضافة خصم</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">الرواتب</h3></div>
                <div class="card-body">
                    مسير شهري: الأساسي + المكافآت − الخصومات = الصافي.
                    <div class="mt-3">
                        <a href="{{ route('dashboard.hr.payrolls.create') }}" class="btn btn-primary btn-sm">إنشاء مسير راتب</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">آخر الموظفين</h3></div>
                <div class="card-body p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>القسم</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentEmployees as $employee)
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->department->name ?? '—' }}</td>
                                    <td>{{ $employee->status }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">لا يوجد موظفون بعد.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">طلبات إجازة معلّقة</h3></div>
                <div class="card-body p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>الموظف</th>
                                <th>النوع</th>
                                <th>من</th>
                                <th>إلى</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingLeaves as $leave)
                                <tr>
                                    <td>{{ $leave->employee->name ?? '—' }}</td>
                                    <td>{{ $leave->type }}</td>
                                    <td>{{ $leave->start_date?->format('Y-m-d') }}</td>
                                    <td>{{ $leave->end_date?->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">لا توجد طلبات معلّقة.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
