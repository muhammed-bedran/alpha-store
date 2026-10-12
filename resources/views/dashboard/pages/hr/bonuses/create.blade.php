@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.bonuses.index') }}">المكافآت</a></li>
    <li class="breadcrumb-item">إضافة</li>
@endsection
@section('title', 'إضافة مكافأة')
@section('content')
<div class="container-fluid hr-wrap">
    @include('dashboard.pages.hr._menu', ['current' => 'bonuses'])
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">مكافأة جديدة</h3></div>
                <form action="{{ route('dashboard.hr.bonuses.store') }}" method="post">
                    @csrf
                    @include('dashboard.pages.hr.bonuses._form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">حفظ</button>
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
