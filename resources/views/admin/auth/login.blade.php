@extends('admin.auth.layouts.template')

@section('content')
    <div class="layout-login-centered-boxed__form card">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-4 navbar-light">
            <a href="{{ route('admin.dashboard.root') }}" class="navbar-brand flex-column mb-1 align-items-center mr-0" style="min-width: 0">
                @if ($logo)
                    <img class="navbar-brand-icon mr-0 mb-3" src="{{ asset('storage/app_logo.png') }}" height="100px" alt="{{ config('app.name') }}">
                @else
                    <small class="mb-3"><i>[[ Logo aplikasi belum dikonfigurasi ]]</i></small>
                @endif
                <div class="text-center" style="line-height: 35px">
                    {{ config('app.name') }} <br>
                    ML Server Admin Dashboard
                </div>
            </a>
        </div>
        @if ( $errors->first('login_gagal') )
            <div class="alert alert-soft-danger d-flex" role="alert">
                <i class="material-icons mr-3">error</i>
                <div class="text-body">
                    <b>{{ $errors->first('login_gagal') }}!!!</b>
                </div>
            </div>
        @endif
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="text-label" for="email_2">Email Admin</label>
                <div class="input-group input-group-merge">
                    <input id="email" name="email" type="email" required="" class="form-control form-control-prepended" placeholder="{{ "admin@".config('app.fqdn') }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="password_2">Password</label>
                <div class="input-group input-group-merge">
                    <input id="password_2" name="password" type="password" required="" class="form-control form-control-prepended" placeholder="Enter your password">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-key"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-primary" type="submit">Login</button>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" checked="" id="remember">
                    <label class="custom-control-label" for="remember">Remember me</label>
                </div>
            </div>
            @if( $errors->first('email') )
                <p class="text-center" style="color: red; margin-top: 10px; margin-bottom: 0">
                    Anda tidak memiliki akses untuk masuk ke halaman admin.
                </p>
            @endif
        </form>
    </div>

@endsection