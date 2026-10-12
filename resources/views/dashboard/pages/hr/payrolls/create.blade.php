@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.payrolls.index') }}">الرواتب</a></li>
    <li class="breadcrumb-item">إنشاء</li>
@endsection
@section('title', 'إنشاء مسير راتب')
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
                <div class="card-header"><h3 class="card-title">مسير راتب جديد</h3></div>
                <form action="{{ route('dashboard.hr.payrolls.store') }}" method="post">
                    @csrf
                    @include('dashboard.pages.hr.payrolls._form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">احتساب وحفظ</button>
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
