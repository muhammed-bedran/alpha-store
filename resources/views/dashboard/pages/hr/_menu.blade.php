@php
    $current = $current ?? '';
@endphp
<div class="mb-3">
    <a href="{{ route('dashboard.hr.index') }}" class="btn {{ $current === 'index' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">نظرة عامة</a>
    <a href="{{ route('dashboard.hr.departments.index') }}" class="btn {{ $current === 'departments' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">الأقسام</a>
    <a href="{{ route('dashboard.hr.employees.index') }}" class="btn {{ $current === 'employees' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">الموظفون</a>
    <a href="{{ route('dashboard.hr.leaves.index') }}" class="btn {{ $current === 'leaves' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">طلبات الإجازات</a>
    <a href="{{ route('dashboard.hr.bonuses.index') }}" class="btn {{ $current === 'bonuses' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">المكافآت</a>
    <a href="{{ route('dashboard.hr.deductions.index') }}" class="btn {{ $current === 'deductions' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">الخصومات</a>
    <a href="{{ route('dashboard.hr.payrolls.index') }}" class="btn {{ $current === 'payrolls' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">الرواتب</a>
    <a href="{{ route('dashboard.hr.about') }}" class="btn {{ $current === 'about' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">شرح الـ HR</a>
</div>
