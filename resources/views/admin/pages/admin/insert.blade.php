@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Master Data,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <form action="{{ route('admin.admin.store') }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Tambah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="nama">Nama</label>
                                        <input class="form-control" type="text" name="nama" id="nama" placeholder="" value="{{ old('nama') }}" autofocus>
                                        @if( $errors->first('nama') )
                                            <small class="text-red">{{ $errors->first('nama') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan nama user</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="email" name="email" id="email" placeholder="" value="{{ old('email') }}" autofocus>
                                        @if( $errors->first('email') )
                                            <small class="text-red">{{ $errors->first('email') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan email user</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="" value="{{ old('password') }}" autofocus>
                                        @if( $errors->first('password') )
                                            <small class="text-red">{{ $errors->first('password') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan password</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="" value="{{ old('password_confirmation') }}" autofocus>
                                        @if( $errors->first('password_confirmation') )
                                            <small class="text-red">{{ $errors->first('password_confirmation') }}</small>
                                        @else
                                            <small class="text-muted">Konfirmasi password yang anda masukkan</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.admin.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
                                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success" value="submit"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection