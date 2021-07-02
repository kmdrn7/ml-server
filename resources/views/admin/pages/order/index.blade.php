@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Transaction,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">

            <x-admin.index-button-control url="" title="order"/>

            <div class="row mt-0">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header card-header-large bg-white">
                            <h4 class="mb-0">{{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Klinik</label>
                                        <select class="form-control select2" id="klinik">
                                            <option value="">Semua</option>
                                            @foreach ($pharmacy as $data)
                                                <option value="{{ $data->serial }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Tanggal Pesanan</label>
                                        <input type="text" class="form-control flatpicker" id="datepick">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-responsive w-100 d-block d-md-table" id="mainDataTable">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Pasien</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Status Pesanan</th>
                                        <th>Status Item</th>
                                        <th width="100"><i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>tanggal</td>
                                        <td>jam</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footer')
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ backend('vendor/daterangepicker.css') }}">
@endsection

@section('js')
    <script src="{{ backend('vendor/daterangepicker.js') }}"></script>
    <script>
        let inc = 0;
        btnView = function(id){
            return '<div class="btn-group btn-group-sm">';
        };
        btnUpdate = function(id){
            return '<a href="{{ url()->current() }}/edit/'+id+'" class="update-button btn btn-info">'
                    +'<i class="fa fa-edit" aria-hidden="true"></i>';
                    +'</a>';
        }
        btnDelete = function(id){
            return '<a class="btn btn-danger" onclick="deleteButton(\''+id+'\')" data-id="'+id+'">'
                    +'<i class="fa fa-trash text-white" aria-hidden="true"></i>';
                    +'</a></div>';
        }

        AjaxData = {
            klinik: () => {
                return $('#klinik').val()
            },
            date: () => {
                return $('#datepick').val()
            }
        }
        ID_TABLE = 'serial'
        SELECT_COLUMNS = []
        COLUMNS = [
            {
                targets: [0],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                targets: [1],
                data: "patient.name"
            },
            {
                targets: [2],
                data: "date"
            },
            {
                targets: [3],
                data: "time"
            },
            {
                targets: [4],
                data: "status"
            },
            {
                targets: [5],
                data: "item_status"
            },
            {
                targets: [6],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    id = full.serial;
                    return btnView(id) + btnUpdate(id) + btnDelete(id);
                }
            }
        ];

        function showData(id) {
            $('#btnLoading').show();
            $('#failLoading').hide();
            console.log(id)
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/view' }}/"+id,
                dataType: "JSON",
                success: function ( res ) {
                    if ( res.status == 200 ) {
                        $('#btnLoading').hide();
                        $('#v1').html(res.data.res.serial);
                        $('#v2').html(res.data.res.name);
                        $('#v3').html(res.data.res.address);
                        $('#v4').html(res.data.res.latitude);
                        $('#v5').html(res.data.res.longitude);
                        $('#v6').html(res.data.account.alpha);
                        $('#v7').html(res.data.res.phone);
                        $('#vcreated').html(res.data.res.createdAt);
                        $('#vupdated').html(res.data.res.updatedAt);
                        $('#viewModal').modal('show');
                    }
                },
                error: function(xhr, options, err){
                    $('#btnLoading').hide();
                    $('#failLoading').show();
                }
            });
        }

        $(document).on('change', '#klinik', ()=>{
            if (inc!=0){
                DT.draw()
            }
        });

        $(document).on('change', '#datepick', ()=>{
            if (inc!=0){
                DT.draw()
            }
        });

        inc++;

        $('#datepick').daterangepicker({
            "autoApply": true,
            "ranges": {
                'Semua': [moment('2020-01-01'), moment()],
                'Sekarang': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Minggu Ini': [moment().startOf('week'), moment().endOf('week')],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            },
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "Dari",
                "toLabel": "Sampai",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "Nopember",
                    "Desember"
                ],
                "firstDay": 1
            },
            "alwaysShowCalendars": true,
            "showDropdowns": true,
        });
    </script>
@endsection