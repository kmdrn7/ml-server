@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Master Data,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <form action="{{ route('admin.ml-model.update', ['id' => $data->id]) }}" class="form-insert" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <input type="hidden" id="_cookie_last_page" name="_cookie_last_page">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ old('name') != '' ? old('name'):$data->name }}" autofocus>
                                            @if( $errors->first('name') )
                                                <small class="text-red">{{ $errors->first('name') }}</small>
                                            @else
                                                <small class="text-muted">Enter model name</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="scaler">Scaler</label>
                                            <div class="form-check" style="margin-bottom: 10px; padding-left: 0px">
                                                <input class="form-check-input" type="radio" name="scaler" value="-" {{ $data->scaler == '-' ? 'checked':'' }}>
                                                <label class="form-check-label" style="margin-left: 5px">-</label>
                                            </div>
                                            <div class="form-check" style="margin-bottom: 10px; padding-left: 0px">
                                                <input class="form-check-input" type="radio" name="scaler" value="MINMAX" {{ $data->scaler == 'MINMAX' ? 'checked':'' }}>
                                                <label class="form-check-label" style="margin-left: 5px">MINMAX</label>
                                            </div>
                                            <div class="form-check" style="margin-bottom: 10px; padding-left: 0px">
                                                <input class="form-check-input" type="radio" name="scaler" value="ZSCORE" {{ $data->scaler == 'ZSCORE' ? 'checked':'' }}>
                                                <label class="form-check-label" style="margin-left: 5px">Z-SCORE</label>
                                            </div>
                                            @if( $errors->first('scaler') )
                                                <small class="text-red">{{ $errors->first('scaler') }}</small>
                                            @else
                                                <small class="text-muted">Choose scaler used in model</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="joblib">Joblib</label>
                                            <input type="file" class="form-control dropify" name="joblib" data-default-file="/public/file/joblib/{{ $data->joblib }}">
                                            @if( $errors->first('joblib') )
                                                <small class="text-red">{{ $errors->first('joblib') }}</small>
                                            @else
                                                <small class="text-muted">Upload joblib file (saved model)</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="features">Features</label>
                                            <textarea name="features" class="form-control" id="features" cols="30" rows="10" placeholder="'SYN Flag Count', 'Fwd Seg Size Min', 'FWD Init Win Bytes', 'Average Packet Size', ...">{{ old('features') != '' ? old('features'):$data->features }}</textarea>
                                            @if( $errors->first('features') )
                                                <small class="text-red">{{ $errors->first('features') }}</small>
                                            @else
                                                <small class="text-muted">Enter features used in this model</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.ml-model.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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