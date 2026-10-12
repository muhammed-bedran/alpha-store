@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.payrolls.index') }}">الرواتب</a></li>
    <li class="breadcrumb-item">إعادة احتساب</li>
@endsection
@section('title', 'إعادة احتساب الراتب')
@section('content')
<div class="container-fluid hr-wrap">
    @include('dashboard.pages.hr._menu', ['current' => 'payrolls'])
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">تحديث مسير {{ $payroll->employee->name ?? '' }}</h3></div>
                <form action="{{ route('dashboard.hr.payrolls.update', $payroll) }}" method="post">
                    @csrf
                    @method('PUT')
                    @include('dashboard.pages.hr.payrolls._form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">إعادة الاحتساب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
