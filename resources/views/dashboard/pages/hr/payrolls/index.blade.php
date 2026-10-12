@php
    $statusLabels = [
        'draft' => 'مسودة',
        'paid' => 'مدفوع',
    ];
@endphp
@extends('layouts.dashboard')

@section('title', 'الرواتب')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">الرواتب</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'payrolls'])

    <a href="{{ route('dashboard.hr.payrolls.create') }}" class="btn btn-primary">إنشاء مسير راتب</a>

    <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="اسم الموظف" value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-2">
            <input type="month" name="period" class="form-control" value="{{ request()->query('period') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">كل الحالات</option>
                @foreach ($statusLabels as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">بحث</button>
        <a href="{{ route('dashboard.hr.payrolls.index') }}" class="btn btn-secondary mx-2">إعادة تعيين</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الموظف</th>
                <th>الشهر</th>
                <th>الأساسي</th>
                <th>المكافآت</th>
                <th>الخصومات</th>
                <th>الصافي</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payrolls as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->employee->name ?? '—' }}</td>
                    <td>{{ $item->period() }}</td>
                    <td>{{ number_format((float) $item->base_salary, 2) }}</td>
                    <td>{{ number_format((float) $item->bonuses_total, 2) }}</td>
                    <td>{{ number_format((float) $item->deductions_total, 2) }}</td>
                    <td><strong>{{ number_format((float) $item->net_salary, 2) }}</strong></td>
                    <td>{{ $statusLabels[$item->status] ?? $item->status }}</td>
                    <td>
                        <a class="btn btn-secondary btn-sm" href="{{ route('dashboard.hr.payrolls.show', $item) }}">عرض</a>
                        @unless ($item->isPaid())
                            <a class="btn btn-primary btn-sm" href="{{ route('dashboard.hr.payrolls.edit', $item) }}">إعادة احتساب</a>
                            <form action="{{ route('dashboard.hr.payrolls.pay', $item) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">دفع</button>
                            </form>
                        @endunless
                        <form action="{{ route('dashboard.hr.payrolls.destroy', $item) }}" method="post" class="d-inline" onsubmit="return confirm('حذف مسير الراتب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">لا توجد مسيرات رواتب بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $payrolls->links() }}
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
