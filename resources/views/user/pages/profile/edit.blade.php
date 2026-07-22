@extends('layouts.dashboard.user')

@section('title', 'Team Member List')
@section('breadcrumb')
    <li class="breadcrumb-item">Team</li>
@endsection
@section('content')
    <x-flash-message />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
        </div>
        </ul>

    @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.profile.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">{{ __('name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name', $user->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <h5 class="mb-3">{{ __('Change Password') }}</h5>

                                <div class="form-group">
                                    <label for="password">{{ __('Current Password') }}</label>
                                    <input type="password" class="form-control" id="password" name="current_password">
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label for="password">{{ __('new Password') }}</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">{{ __('dashboard.back') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


@endsection

@push('styles')
    <style>
    </style>

@endpush

@push('scripts')
    <script>

    </script>
@endpush