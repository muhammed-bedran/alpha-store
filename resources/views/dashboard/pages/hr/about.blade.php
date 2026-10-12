@extends('layouts.dashboard')

@section('title', 'شرح الموارد البشرية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.hr.index') }}">HR</a></li>
    <li class="breadcrumb-item">شرح</li>
@endsection

@section('content')
<div class="container-fluid hr-wrap">
    @include('dashboard.pages.hr._menu', ['current' => 'about'])
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ما هو الـ HR؟ أقسامه، فائدته، ولماذا نعمله</h3>
        </div>
        <div class="card-body hr-docs">
            {!! $html !!}
        </div>
    </div>
</div>
@endsection

@push('styles')
    @include('dashboard.pages.hr._styles')
@endpush
