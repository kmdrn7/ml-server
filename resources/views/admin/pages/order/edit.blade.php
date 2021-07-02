@extends('admin.layouts.app')

@section('title', $state.' | '.$title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Transaction,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <form action="{{ route('admin.order.update', ['id' => $data->serial]) }}" class="form-insert" method="POST">
                            @csrf
                            <div class="card-header card-header-large bg-white">
                                <h1 class="text-center mb-0" style="font-size: 20px">FORM <small style="font-size: 18px">Ubah Data</small></h1>
                            </div>
                            <div class="card-body pb-1">
                                <input type="hidden" id="_cookie_last_page" name="_cookie_last_page">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Nama</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="" value="{{ old('name') != '' ? old('name') : $data->patient->name }}" readonly>
                                        <small class="text-muted">Masukkan name pasien</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nik">NIK</label>
                                        <input class="form-control" type="text" name="nik" id="nik" placeholder="" value="{{ old('nik') != '' ? old('nik') : $data->patient->nik }}" readonly>
                                        <small class="text-muted">Masukkan nik pasien</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="date">Tanggal</label>
                                        <input class="form-control" type="text" name="date" id="date" placeholder="" value="{{ old('date') != '' ? old('date') : $data->date->format('Y-m-d') }}" readonly>
                                        <small class="text-muted">Masukkan tanggal layanan</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="time">Waktu</label>
                                        <input class="form-control" type="text" name="time" id="time" placeholder="" value="{{ old('time') != '' ? old('time') : $data->time }}" readonly>
                                        <small class="text-muted">Masukkan waktu layanan</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="doctor">Dokter</label>
                                        <input class="form-control" type="text" name="doctor" id="doctor" placeholder="" value="{{ old('doctor') != '' ? old('doctor') : $data->doctor->name }}" readonly>
                                        <small class="text-muted">Masukkan name dokter</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="service">Jenis Layanan</label>
                                        <input class="form-control" type="text" name="service" id="service" placeholder="" value="{{ old('service') != '' ? old('service') : $data->serviceType }}" readonly>
                                        <small class="text-muted">Masukkan jenis layanan</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status Pemesanan Layanan</label>
                                        <select class="form-control select2" name="status_order">
                                            @foreach ($orderStatus as $item)
                                                <option value="{{ $item }}" {{ $data->status==$item?'selected':'' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->first('status_order') )
                                            <small class="text-red">{{ $errors->first('status_order') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan status pemesanan layanan</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status Layanan Item</label>
                                        <select class="form-control select2" name="status_item">
                                            <option value="">-</option>
                                            @foreach ($orderItemStatus as $item)
                                                <option value="{{ $item }}" {{ $data->item_status==$item?'selected':'' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->first('status_item') )
                                            <small class="text-red">{{ $errors->first('status_item') }}</small>
                                        @else
                                            <small class="text-muted">Masukkan status pemesanan item</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group mt-2 mb-2" style="text-align: right">
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-warning text-white"><i class="fa fa-reply"></i>&nbsp; Kembali</a>
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