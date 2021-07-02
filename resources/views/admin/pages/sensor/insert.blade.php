@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Management,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <form action="{{ route('admin.sensor.store') }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Tambah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ old('name') }}" autofocus>
                                            @if( $errors->first('name') )
                                                <small class="text-red">{{ $errors->first('name') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan nama sensor</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="os">OS</label>
                                            <select name="os" id="os" class="form-control select2">
                                                <option value="" selected disabled>All</option>
                                                <option value="Linux">Linux</option>
                                                <option value="Win">Win</option>
                                            </select>
                                            @if( $errors->first('os') )
                                                <small class="text-red">{{ $errors->first('os') }}</small>
                                            @else
                                                <small class="text-muted">Pilih OS</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="arch">Arch</label>
                                            <select name="arch" id="arch" class="form-control select2">
                                                <option value="" selected disabled>All</option>
                                                <option value="AMD64">AMD64</option>
                                                <option value="ARMv7">ARMv7</option>
                                                <option value="ARMv8">ARMv8</option>
                                            </select>
                                            @if( $errors->first('arch') )
                                                <small class="text-red">{{ $errors->first('arch') }}</small>
                                            @else
                                                <small class="text-muted">Pilih Architecture</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.sensor.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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