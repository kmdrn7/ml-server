@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('css')
    <style>
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }
        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 12px;
            font-weight: 300;
            margin-top: 40px;
            left: 5px !important;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
        }
        #pac-input:focus {
            border-color: #4d90fe;
        }
        .pac-container {
            font-family: Roboto;
        }
        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }
        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
        #target {
            width: 345px;
        }
    </style>
@endsection

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Master Data,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.pharmacy.update', ['id' => $data->serial]) }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <input type="hidden" id="_cookie_last_page" name="_cookie_last_page">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="name">Nama</label>
                                                <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ old('name') != '' ? old('name') : $data->name }}" autofocus>
                                                @if( $errors->first('name') )
                                                    <small class="text-red">{{ $errors->first('name') }}</small>
                                                @else
                                                    <small class="text-muted">Masukkan name user</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="address">Alamat</label>
                                                <textarea name="address" id="address" cols="30" rows="7" class="form-control">{{ old('address') != '' ? old('address') : $data->address }}</textarea>
                                                @if( $errors->first('address') )
                                                    <small class="text-red">{{ $errors->first('address') }}</small>
                                                @else
                                                    <small class="text-muted">Masukkan alamat</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="latitude">Latitude</label>
                                                <input class="form-control" type="text" name="latitude" id="latLabel" placeholder="" value="{{ old('latitude') != '' ? old('latitude') : $data->latitude }}" readonly>
                                                <input class="form-control" type="hidden" name="lat" id="lat" placeholder="" value="{{ $data->latitude }}">
                                                @if( $errors->first('latitude') )
                                                    <small class="text-red">{{ $errors->first('latitude') }}</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="longitude">Longitude</label>
                                                <input class="form-control" type="text" name="longitude" id="longLabel" placeholder="" value="{{ old('longitude') != '' ? old('longitude') : $data->longitude }}" readonly>
                                                <input class="form-control" type="hidden" name="long" id="long" placeholder="" value="{{ $data->longitude }}">
                                                @if( $errors->first('longitude') )
                                                    <small class="text-red">{{ $errors->first('longitude') }}</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Nomor Telepon</label>
                                                <input class="form-control" type="text" name="phone" id="phone" placeholder="" value="{{ old('phone') != '' ? old('phone') : $data->phone }}">
                                                @if( $errors->first('phone') )
                                                    <small class="text-red">{{ $errors->first('phone') }}</small>
                                                @else
                                                    <small class="text-muted">Masukkan nomor telepon</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="alpha">Username</label>
                                                <input class="form-control" type="text" name="alpha" id="alpha" placeholder="" value="{{ old('alpha') != '' ? old('alpha') : $account->alpha }}">
                                                @if( $errors->first('alpha') )
                                                    <small class="text-red">{{ $errors->first('alpha') }}</small>
                                                @else
                                                    <small class="text-muted">Masukkan username</small>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div style="padding: 6px 5px;">
                                                    <input type="checkbox" class="checkbox-template" id="is_password" name="is_password">
                                                    <label for="is_password">&nbsp; Ganti Password</label>
                                                </div>
                                                @if( $errors->first('nama_event') )
                                                    <small id="helpId" class="text-red">{{ $errors->first('is_free') }}</small>
                                                @else
                                                    <small id="helpId" class="text-muted">Centang checkbox jika ingin mengganti password, biarkan jika tidak ingin mengganti</small>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row" id="password_container" style="display: none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password">Password</label>
                                                            <input class="form-control" type="password" name="password" id="password" placeholder="" value="{{ old('password') }}" autofocus>
                                                            @if( $errors->first('password') )
                                                                <small class="text-red">{{ $errors->first('password') }}</small>
                                                            @else
                                                                <small class="text-muted">Masukkan password *panjang password minimal 5 anka</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12" style="position: relative">
                                            <label for="map">Lokasi</label>
                                            <input id="pac-input" class="controls" type="text" placeholder="Cari lokasi klinik">
                                            <div id="map" style="height: 500px"></div>
                                            @value( $errors->first('lat') )
                                                <small id="helpId" class="text-red">{{ $errors->first('lat') }}</small>
                                            @else
                                                <small id="helpId" class="text-muted">Tentukan lokasi klinik di peta ( geser peta sampai penunjuk <span style="color:red">merah</span> besar ada di atas lokasi)</small>
                                            @endvalue
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.pharmacy.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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

@section('js')
    <script>
        let map, marker, center, position,
            lati = $('#lat').val(),
            longi = $('#long').val();

        if (!navigator.geolocation) {
            alert('Browser tidak support geolocation, silahkan cek penganturan browser yang anda gunakan');
        } else {
            navigator.geolocation.getCurrentPosition(showPosition);
        }

        function showPosition(position) {
            console.log('showpos')
        }

        $(document).ready(function () {
            $('#is_password').on('ifChanged', function (e) {
                if ( this.checked ) {
                    $('#password_container').show('300');
                } else {
                    $('#password_container').hide('300');
                }
            });
        });

        function initMap() {
            position = {
                lat: parseFloat(lati), lng: parseFloat(longi)
            };
            $('#latLabel').text(lati)
            $('#longLabel').text(longi)
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 19,
                controlSize: 26,
                center: position
            });
            marker = new google.maps.Marker({
                map: map,
                draggable: false,
                animation: google.maps.Animation.DROP,
                position: position
            });
            map.addListener('center_changed', function (evt) {
                // 0.1 seconds after the center of the map has changed,
                // set back the marker position.
                window.setTimeout(function () {
                    center = map.getCenter();
                    $('#latLabel').val(center.lat())
                    $('#longLabel').val(center.lng())
                    $('#lat').val(center.lat().toFixed(7));
                    $('#long').val(center.lng().toFixed(7));
                    marker.setPosition(center);
                }, 100);
            });
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };
                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    try {
                        document.getElementById('lat').value = String(place.geometry.location.lat());
                        document.getElementById('long').value = String(place.geometry.location.lng());
                    } catch (error) {
                        console.log("Error: tidak bisa menemukan lat dan lng");
                    }
                });
                map.fitBounds(bounds);
            });
        }

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }

        $(document).ready(function () {
            google.maps.event.addDomListener(window, 'load', initMap);
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCkWqdycV5ebmS39YTjojA0JsgGTM3TykE&libraries=places"></script>
@endsection