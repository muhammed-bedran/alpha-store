@extends('layouts.dashboard.user')

@section('title', 'Dashboard')

@section('content')
    <x-flash-message />

    @if (!$user->hasStore())
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Welcome, {{ $user->name }}!</h3>
            </div>
            <div class="card-body">
                <p>You don't have a store yet. <a href="{{ route('user.store.create') }}">Create one</a></p>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['products_count'] }}</h3>

                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['teams_count'] }}</h3>

                            <p>Teams</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Team: {{ $stats['teams_count'] }}</h3>
                            <h3>{{ $stats['store_status'] }}</h3>

                            <p>Store Status</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- /.col-md-6 -->

                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->

    @endif




@endsection