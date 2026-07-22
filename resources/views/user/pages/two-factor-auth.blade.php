@extends('layouts.dashboard.user')
@section('breadcrumb')

    <li class="breadcrumb-item active">Two-Factor Authentication</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Two-Factor Authentication</h3>
                </div>
                <div class="card-body">
                    <!-- Two-factor authentication content goes here -->
                    <p>Two-factor authentication (2FA) adds an extra layer of security to your account by requiring a second
                        form of verification in addition to your password. This helps protect your account from unauthorized
                        access, even if someone obtains your password.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (!$user->two_factor_secret)
                        <p>Two-factor authentication is not enabled for this account.</p>
                        <form method="Post" action="{{ route('two-factor.enable') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Enable Two-Factor Authentication</button>

                        </form>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Two-factor authentication is enabled for this account.</h5>
                                <h5>Scan the QR code below to set up your authenticator app.</h5>
                                <div class="mb-3">
                                    {!! $user->twoFactorQrCodeSvg() !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Recovery Codes</h5>
                                <p>Keep these recovery codes in a safe place. You can use them to access your account if you
                                    lose access to your authenticator app.</p>
                                <ul class="list-group" mb-3>
                                    @foreach ($user->recoveryCodes() as $code)
                                        <li class="list-group-item">{{ $code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <form method="Post" action="{{ route('two-factor.disable') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Disable Two-Factor Authentication</button>

                        </form>

                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')

@endpush