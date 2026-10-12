@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.leaves.index') }}">الإجازات</a></li>
    <li class="breadcrumb-item">تعديل</li>
@endsection
@section('title', 'تعديل طلب إجازة')
@section('content')
<div class="container-fluid hr-wrap">
    @include('dashboard.pages.hr._menu', ['current' => 'leaves'])
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
                <div class="card-header"><h3 class="card-title">تعديل الطلب</h3></div>
                <form action="{{ route('dashboard.hr.leaves.update', $leave) }}" method="post">
                    @csrf
                    @method('PUT')
                    @include('dashboard.pages.hr.leaves._form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">تحديث</button>
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
