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
                        <form action="{{ route('admin.sensor.update', ['id' => $data->id]) }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <h5 class="" style="margin-bottom: 20px">Informasi Sensor</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ $data->name }}" autofocus>
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
                                                <option value="" disabled>All</option>
                                                <option value="Linux" {{ $data->os == "Linux" ? "selected":"" }}>Linux</option>
                                                <option value="Win" {{ $data->os == "Win" ? "selected":"" }}>Win</option>
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
                                                <option value="" disabled>All</option>
                                                <option value="AMD64" {{ $data->arch == "AMD64" ? "selected":"" }}>AMD64</option>
                                                <option value="ARMv7" {{ $data->arch == "ARMv7" ? "selected":"" }}>ARMv7</option>
                                                <option value="ARMv8" {{ $data->arch == "ARMv8" ? "selected":"" }}>ARMv8</option>
                                            </select>
                                            @if( $errors->first('arch') )
                                                <small class="text-red">{{ $errors->first('arch') }}</small>
                                            @else
                                                <small class="text-muted">Pilih Architecture</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <hr style="border-style: dashed">
                                        <h5 class="">Environment Variables [Sensor]</h5>
                                    </div>
                                    @php
                                        $config = json_decode($data->config);
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="interface">Listen Interface</label>
                                            <input class="form-control" type="text" name="interface" id="interface" placeholder="" value="{{ $config->LISTEN_INTERFACE }}">
                                            @if( $errors->first('interface') )
                                                <small class="text-red">{{ $errors->first('interface') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan nama interface</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mlserver">ML Server URL</label>
                                            <input class="form-control" type="text" name="mlserver" id="mlserver" placeholder="" value="{{ $config->MLSERVER_URL }}">
                                            @if( $errors->first('mlserver') )
                                                <small class="text-red">{{ $errors->first('mlserver') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan alamat ml-server</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kafka_host">Kafka Host</label>
                                            <input class="form-control" type="text" name="kafka_host" id="kafka_host" placeholder="" value="{{ $config->KAFKA_HOST }}">
                                            @if( $errors->first('kafka_host') )
                                                <small class="text-red">{{ $errors->first('kafka_host') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan host kafka</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kafka_port">Kafka Port</label>
                                            <input class="form-control" type="text" name="kafka_port" id="kafka_port" placeholder="" value="{{ $config->KAFKA_PORT }}">
                                            @if( $errors->first('kafka_port') )
                                                <small class="text-red">{{ $errors->first('kafka_port') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan port kafka</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kafka_topic">Kafka Topic</label>
                                            <input class="form-control" type="text" name="kafka_topic" id="kafka_topic" placeholder="" value="{{ $config->KAFKA_TOPIC }}">
                                            @if( $errors->first('kafka_topic') )
                                                <small class="text-red">{{ $errors->first('kafka_topic') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan nama kafka topic</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <hr style="border-style: dashed">
                                        <h5 class="">Environment Variables [Data Processor]</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kafka_group">Kafka Group ID</label>
                                            <input class="form-control" type="text" name="kafka_group" id="kafka_group" placeholder="" value="{{ $config->KAFKA_GROUP }}">
                                            @if( $errors->first('kafka_group') )
                                                <small class="text-red">{{ $errors->first('kafka_group') }}</small>
                                            @else
                                                <small class="text-muted">Masukkan id kafka group</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.sensor.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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