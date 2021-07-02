@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Utilitas,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <form action="{{ route('admin.version.update', ['id' => $data->appID]) }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <input type="hidden" id="_cookie_last_page" name="_cookie_last_page">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="appid">APP ID</label>
                                        <input class="form-control" type="text" name="appid" id="appid" placeholder="" value="{{ $data->appID }}" readonly>
                                        <small class="text-muted">ID aplikasi</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="version">Versi</label>
                                        <input class="form-control" type="text" name="version" id="version" placeholder="" value="{{ old('version') != '' ? old('version') : $data->version }}">
                                        @if( $errors->first('version') )
                                            <small class="text-red">{{ $errors->first('version') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan versi aplikasi</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.version.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
                                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success" value="submit"><i class="fa fa-save"></i>&nbsp; Simpan perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
