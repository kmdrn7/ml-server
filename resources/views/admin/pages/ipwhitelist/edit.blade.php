@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Manajemen,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <form action="{{ route('admin.ip-whitelist.update', ['id' => $data->serial]) }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <input type="hidden" id="_cookie_last_page" name="_cookie_last_page">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ $data->name }}" readonly>
                                        <small class="text-muted">Nama IP</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="ipv4">IPv4</label>
                                        <input class="form-control" type="text" name="ipv4" id="ipv4" placeholder="" value="{{ $data->IPv4 }}" readonly>
                                        <small class="text-muted">IPv4</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="ipv6">IPv6</label>
                                        <input class="form-control" type="text" name="ipv6" id="ipv6" placeholder="" value="{{ $data->IPV6 }}" readonly>
                                        <small class="text-muted">IPv6</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="status">Status Approval</label>
                                        <select class="form-control select2" name="status">
                                            <option value="1" {{ $data->status == 1 ? 'selected':'' }}>Approved</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected':'' }}>Pending</option>
                                        </select>
                                        @if( $errors->first('status') )
                                            <small class="text-red">{{ $errors->first('status') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan status approval alamat IP</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.ip-whitelist.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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
