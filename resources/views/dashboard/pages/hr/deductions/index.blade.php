@php
    $typeLabels = [
        'late' => 'تأخير',
        'absence' => 'غياب',
        'loan' => 'سلفة / قرض',
        'penalty' => 'جزاء',
        'tax' => 'ضريبة / تأمين',
        'other' => 'أخرى',
    ];
@endphp
@extends('layouts.dashboard')

@section('title', 'الخصومات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">الخصومات</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'deductions'])

    <a href="{{ route('dashboard.hr.deductions.create') }}" class="btn btn-primary">إضافة خصم</a>

    <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="بحث بالموظف أو العنوان" value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-control">
                <option value="">كل الأنواع</option>
                @foreach ($typeLabels as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">بحث</button>
        <a href="{{ route('dashboard.hr.deductions.index') }}" class="btn btn-secondary mx-2">إعادة تعيين</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الموظف</th>
                <th>العنوان</th>
                <th>النوع</th>
                <th>المبلغ</th>
                <th>التاريخ</th>
                <th colspan="2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deductions as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->employee->name ?? '—' }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $typeLabels[$item->type] ?? $item->type }}</td>
                    <td>{{ number_format((float) $item->amount, 2) }}</td>
                    <td>{{ $item->date?->format('Y-m-d') }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.hr.deductions.edit', $item) }}">تعديل</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.hr.deductions.destroy', $item) }}" method="post" onsubmit="return confirm('حذف هذا الخصم؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">لا توجد خصومات بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $deductions->links() }}
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
