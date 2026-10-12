@php
    $statusLabels = [
        'active' => 'نشط',
        'on_leave' => 'في إجازة',
        'inactive' => 'غير نشط',
        'terminated' => 'منتهي الخدمة',
    ];
@endphp
@extends('layouts.dashboard')

@section('title', 'الموظفون')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">الموظفون</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'employees'])

    <a href="{{ route('dashboard.hr.employees.create') }}" class="btn btn-primary">إضافة موظف</a>

    <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="بحث بالاسم أو الإيميل أو الوظيفة" value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-3">
            <select name="department_id" class="form-control">
                <option value="">كل الأقسام</option>
                @foreach ($departments as $id => $name)
                    <option value="{{ $id }}" @selected((string) request('department_id') === (string) $id)>{{ $name }}</option>
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
        <a href="{{ route('dashboard.hr.employees.index') }}" class="btn btn-secondary mx-2">إعادة تعيين</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>القسم</th>
                <th>الوظيفة</th>
                <th>الراتب</th>
                <th>الحالة</th>
                <th colspan="2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->department->name ?? '—' }}</td>
                    <td>{{ $item->job_title }}</td>
                    <td>{{ $item->salary }}</td>
                    <td>{{ $statusLabels[$item->status] ?? $item->status }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.hr.employees.edit', $item) }}">تعديل</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.hr.employees.destroy', $item) }}" method="post" onsubmit="return confirm('حذف هذا الموظف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">لا يوجد موظفون بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $employees->links() }}
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
