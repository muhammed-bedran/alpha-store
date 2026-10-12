@php
    $bonusTypes = [
        'performance' => 'أداء',
        'overtime' => 'عمل إضافي',
        'holiday' => 'مناسبة / عيد',
        'commission' => 'عمولة',
        'other' => 'أخرى',
    ];
    $deductionTypes = [
        'late' => 'تأخير',
        'absence' => 'غياب',
        'loan' => 'سلفة / قرض',
        'penalty' => 'جزاء',
        'tax' => 'ضريبة / تأمين',
        'other' => 'أخرى',
    ];
@endphp
@extends('layouts.dashboard')

@section('title', 'تفاصيل الراتب')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.payrolls.index') }}">الرواتب</a></li>
    <li class="breadcrumb-item">{{ $payroll->period() }}</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'payrolls'])

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">ملخص {{ $payroll->employee->name ?? '' }}</h3></div>
                <div class="card-body">
                    <p>الشهر: <strong>{{ $payroll->period() }}</strong></p>
                    <p>الأساسي: {{ number_format((float) $payroll->base_salary, 2) }}</p>
                    <p>المكافآت: {{ number_format((float) $payroll->bonuses_total, 2) }}</p>
                    <p>الخصومات: {{ number_format((float) $payroll->deductions_total, 2) }}</p>
                    <p>الصافي: <strong>{{ number_format((float) $payroll->net_salary, 2) }}</strong></p>
                    <p>الحالة: {{ $payroll->isPaid() ? 'مدفوع' : 'مسودة' }}</p>
                    @if ($payroll->paid_at)
                        <p>تاريخ الدفع: {{ $payroll->paid_at->format('Y-m-d H:i') }}</p>
                    @endif
                    @if ($payroll->notes)
                        <p>ملاحظات: {{ $payroll->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">مكافآت الشهر</h3></div>
                <div class="card-body p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bonuses as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $bonusTypes[$item->type] ?? $item->type }}</td>
                                    <td>{{ number_format((float) $item->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">لا توجد مكافآت لهذا الشهر.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header"><h3 class="card-title">خصومات الشهر</h3></div>
                <div class="card-body p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deductions as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $deductionTypes[$item->type] ?? $item->type }}</td>
                                    <td>{{ number_format((float) $item->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3">لا توجد خصومات لهذا الشهر.</td></tr>
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
