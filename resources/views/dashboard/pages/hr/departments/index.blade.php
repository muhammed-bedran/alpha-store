@extends('layouts.dashboard')

@section('title', 'أقسام الموارد البشرية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">الأقسام</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'departments'])

    <a href="{{ route('dashboard.hr.departments.create') }}" class="btn btn-primary">إضافة قسم</a>

    <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="بحث بالاسم" value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">كل الحالات</option>
                <option value="active" @selected(request('status') === 'active')>نشط</option>
                <option value="inactive" @selected(request('status') === 'inactive')>غير نشط</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">بحث</button>
        <a href="{{ route('dashboard.hr.departments.index') }}" class="btn btn-secondary mx-2">إعادة تعيين</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>عدد الموظفين</th>
                <th>الحالة</th>
                <th>الوصف</th>
                <th colspan="2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($departments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->employees_count }}</td>
                    <td>{{ $item->status === 'active' ? 'نشط' : 'غير نشط' }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.hr.departments.edit', $item) }}">تعديل</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.hr.departments.destroy', $item) }}" method="post" onsubmit="return confirm('حذف هذا القسم؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">لا توجد أقسام بعد.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $departments->links() }}
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
