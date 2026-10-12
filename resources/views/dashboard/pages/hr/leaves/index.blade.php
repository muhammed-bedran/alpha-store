@php
    $typeLabels = [
        'annual' => 'سنوية',
        'sick' => 'مرضية',
        'unpaid' => 'بدون راتب',
        'emergency' => 'طارئة',
    ];
    $statusLabels = [
        'pending' => 'قيد المراجعة',
        'approved' => 'معتمدة',
        'rejected' => 'مرفوضة',
    ];
@endphp
@extends('layouts.dashboard')

@section('title', 'طلبات الإجازات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">الإجازات</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'leaves'])

    <a href="{{ route('dashboard.hr.leaves.create') }}" class="btn btn-primary">تسجيل طلب إجازة</a>

    <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="اسم الموظف" value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-2">
            <select name="type" class="form-control">
                <option value="">كل الأنواع</option>
                @foreach ($typeLabels as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
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
        <a href="{{ route('dashboard.hr.leaves.index') }}" class="btn btn-secondary mx-2">إعادة تعيين</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الموظف</th>
                <th>النوع</th>
                <th>من</th>
                <th>إلى</th>
                <th>الأيام</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leaves as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->employee->name ?? '—' }}</td>
                    <td>{{ $typeLabels[$item->type] ?? $item->type }}</td>
                    <td>{{ $item->start_date?->format('Y-m-d') }}</td>
                    <td>{{ $item->end_date?->format('Y-m-d') }}</td>
                    <td>{{ $item->days }}</td>
                    <td>{{ $statusLabels[$item->status] ?? $item->status }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.hr.leaves.edit', $item) }}">تعديل</a>
                        @if ($item->status === 'pending')
                            <form action="{{ route('dashboard.hr.leaves.approve', $item) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">اعتماد</button>
                            </form>
                            <form action="{{ route('dashboard.hr.leaves.reject', $item) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">رفض</button>
                            </form>
                        @endif
                        <form action="{{ route('dashboard.hr.leaves.destroy', $item) }}" method="post" class="d-inline" onsubmit="return confirm('حذف هذا الطلب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">لا توجد طلبات إجازة.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $leaves->links() }}
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
