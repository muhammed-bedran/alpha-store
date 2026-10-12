@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.deductions.index') }}">الخصومات</a></li>
    <li class="breadcrumb-item">تعديل</li>
@endsection
@section('title', 'تعديل خصم')
@section('content')
<div class="container-fluid hr-wrap">
    @include('dashboard.pages.hr._menu', ['current' => 'deductions'])
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header"><h3 class="card-title">تعديل الخصم</h3></div>
                <form action="{{ route('dashboard.hr.deductions.update', $deduction) }}" method="post">
                    @csrf
                    @method('PUT')
                    @include('dashboard.pages.hr.deductions._form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger">تحديث</button>
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
